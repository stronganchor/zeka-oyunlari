param(
	[switch] $Force
)

$ErrorActionPreference = 'Stop'

Add-Type -AssemblyName System.Drawing

$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$gamesRoot = Join-Path $root 'games'
$width = 1200
$height = 750

$themes = @(
	@{ Keys = 'chess|dama|sudoku|puzzle|maze|memory|word|number|binary|logic|rule|grid|pipe|cryptogram'; From = '#243b53'; To = '#14b8a6'; Accent = '#d9f99d'; Label = 'LOGIC' },
	@{ Keys = 'race|runner|car|soccer|shoot|battle|defense|army|fight|ninja|tower|zombie|arena'; From = '#8f1d2c'; To = '#fb923c'; Accent = '#fee2e2'; Label = 'ACTION' },
	@{ Keys = 'treasure|temple|pirate|dragon|magic|mystery|quest|hazine|misir|anubis|crystal|jungle|cave'; From = '#5b21b6'; To = '#f472b6'; Accent = '#fef3c7'; Label = 'QUEST' },
	@{ Keys = 'clock|time|calculator|builder|sort|designer|paint|language|code'; From = '#0f766e'; To = '#38bdf8'; Accent = '#ccfbf1'; Label = 'SKILL' },
	@{ Keys = 'space|orbit|quantum|nova|rocket|alien|moon|zero'; From = '#1e1b4b'; To = '#22d3ee'; Accent = '#e0e7ff'; Label = 'SPACE' },
	@{ Keys = 'animal|duck|penguin|dino|zoo|garden|fruit|candy|micro|ocean'; From = '#166534'; To = '#facc15'; Accent = '#f0fdf4'; Label = 'PLAY' }
)

function Convert-HexToColor {
	param([string] $Hex)

	$clean = $Hex.TrimStart('#')
	return [System.Drawing.Color]::FromArgb(
		[Convert]::ToInt32($clean.Substring(0, 2), 16),
		[Convert]::ToInt32($clean.Substring(2, 2), 16),
		[Convert]::ToInt32($clean.Substring(4, 2), 16)
	)
}

function Get-TitleFromGameFile {
	param([string] $GameFile, [string] $Fallback)

	$content = [string] (Get-Content -LiteralPath $GameFile -Raw)
	$patterns = @(
		"'name'\s*=>\s*'([^']+)'",
		'"name"\s*=>\s*"([^"]+)"'
	)

	foreach ($pattern in $patterns) {
		$match = [regex]::Match($content, $pattern)
		if ($match.Success) {
			return [System.Text.RegularExpressions.Regex]::Unescape($match.Groups[1].Value)
		}
	}

	$parts = $Fallback -replace '[-_]+', ' ' -split '\s+'
	$title = ($parts | Where-Object { $_ -ne '' } | ForEach-Object {
		if ($_.Length -le 1) { $_.ToUpperInvariant() } else { $_.Substring(0, 1).ToUpperInvariant() + $_.Substring(1) }
	}) -join ' '

	return $title
}

function Get-Theme {
	param([string] $Text)

	$needle = $Text.ToLowerInvariant()
	foreach ($theme in $themes) {
		if ($needle -match $theme.Keys) {
			return $theme
		}
	}

	$index = [Math]::Abs($needle.GetHashCode()) % $themes.Count
	return $themes[$index]
}

function Get-Initials {
	param([string] $Title)

	$words = $Title -split '\s+'
	$letters = ''
	foreach ($word in $words) {
		$clean = $word.Trim()
		if ($clean -eq '') {
			continue
		}
		$letters += $clean.Substring(0, 1).ToUpperInvariant()
		if ($letters.Length -ge 2) {
			break
		}
	}

	if ($letters -eq '') {
		return 'ZO'
	}

	return $letters
}

function New-RoundedRectanglePath {
	param([float] $X, [float] $Y, [float] $W, [float] $H, [float] $R)

	$path = New-Object System.Drawing.Drawing2D.GraphicsPath
	$diameter = $R * 2
	$path.AddArc($X, $Y, $diameter, $diameter, 180, 90)
	$path.AddArc($X + $W - $diameter, $Y, $diameter, $diameter, 270, 90)
	$path.AddArc($X + $W - $diameter, $Y + $H - $diameter, $diameter, $diameter, 0, 90)
	$path.AddArc($X, $Y + $H - $diameter, $diameter, $diameter, 90, 90)
	$path.CloseFigure()
	return $path
}

function Draw-CenteredText {
	param(
		[System.Drawing.Graphics] $Graphics,
		[string] $Text,
		[System.Drawing.Font] $Font,
		[System.Drawing.Brush] $Brush,
		[System.Drawing.RectangleF] $Rect
	)

	$format = New-Object System.Drawing.StringFormat
	$format.Alignment = [System.Drawing.StringAlignment]::Center
	$format.LineAlignment = [System.Drawing.StringAlignment]::Center
	$format.Trimming = [System.Drawing.StringTrimming]::EllipsisWord
	$Graphics.DrawString($Text, $Font, $Brush, $Rect, $format)
	$format.Dispose()
}

function Draw-GamePicture {
	param(
		[System.Drawing.Graphics] $Graphics,
		[hashtable] $Theme,
		[string] $FolderName,
		[System.Drawing.Color] $Accent
	)

	$white = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(236, 255, 255, 255))
	$softWhite = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(90, 255, 255, 255))
	$shadow = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(58, 15, 23, 42))
	$accentBrush = New-Object System.Drawing.SolidBrush $Accent
	$darkPen = New-Object System.Drawing.Pen ([System.Drawing.Color]::FromArgb(118, 15, 23, 42)), 8
	$whitePen = New-Object System.Drawing.Pen ([System.Drawing.Color]::FromArgb(210, 255, 255, 255)), 8
	$thinPen = New-Object System.Drawing.Pen ([System.Drawing.Color]::FromArgb(150, 255, 255, 255)), 4

	switch ($Theme.Label) {
		'LOGIC' {
			$tile = 74
			$startX = 363
			$startY = 210
			for ($row = 0; $row -lt 4; $row++) {
				for ($col = 0; $col -lt 5; $col++) {
					$path = New-RoundedRectanglePath ($startX + $col * ($tile + 10)) ($startY + $row * ($tile + 10)) $tile $tile 14
					$brush = if ((($row + $col) % 2) -eq 0) { $white } else { $softWhite }
					$Graphics.FillPath($brush, $path)
					$path.Dispose()
				}
			}
			$Graphics.DrawLine($darkPen, 400, 520, 510, 438)
			$Graphics.DrawLine($darkPen, 510, 438, 622, 438)
			$Graphics.DrawLine($darkPen, 622, 438, 760, 292)
			$Graphics.FillEllipse($accentBrush, 380, 500, 46, 46)
			$Graphics.FillEllipse($accentBrush, 740, 270, 54, 54)
		}
		'ACTION' {
			$road = New-Object System.Drawing.Drawing2D.GraphicsPath
			$road.AddPolygon(@(
				(New-Object System.Drawing.Point 510, 170),
				(New-Object System.Drawing.Point 690, 170),
				(New-Object System.Drawing.Point 920, 610),
				(New-Object System.Drawing.Point 280, 610)
			))
			$Graphics.FillPath($shadow, $road)
			$Graphics.DrawLine($thinPen, 600, 206, 600, 570)
			$car = New-RoundedRectanglePath 458 378 284 116 28
			$Graphics.FillPath($white, $car)
			$Graphics.FillEllipse($shadow, 500, 468, 58, 58)
			$Graphics.FillEllipse($shadow, 642, 468, 58, 58)
			$Graphics.FillRectangle($accentBrush, 520, 332, 160, 62)
			$Graphics.FillEllipse($softWhite, 768, 246, 86, 86)
			$road.Dispose()
			$car.Dispose()
		}
		'QUEST' {
			$Graphics.FillPolygon($shadow, @(
				(New-Object System.Drawing.Point 600, 160),
				(New-Object System.Drawing.Point 812, 365),
				(New-Object System.Drawing.Point 388, 365)
			))
			$Graphics.FillRectangle($softWhite, 420, 360, 360, 190)
			for ($i = 0; $i -lt 4; $i++) {
				$Graphics.FillRectangle($white, 456 + $i * 82, 392, 42, 158)
			}
			$chest = New-RoundedRectanglePath 455 505 290 100 24
			$Graphics.FillPath($accentBrush, $chest)
			$Graphics.DrawLine($darkPen, 455, 550, 745, 550)
			$Graphics.FillEllipse($white, 584, 538, 34, 34)
			$chest.Dispose()
		}
		'SKILL' {
			for ($i = 0; $i -lt 4; $i++) {
				$x = 360 + $i * 130
				$Graphics.DrawEllipse($whitePen, $x, 230, 96, 96)
				$Graphics.FillEllipse($softWhite, $x + 28, 258, 40, 40)
				if ($i -lt 3) {
					$Graphics.DrawLine($thinPen, $x + 96, 278, $x + 130, 278)
				}
			}
			$Graphics.DrawLine($darkPen, 370, 450, 820, 450)
			$Graphics.DrawLine($darkPen, 460, 450, 460, 540)
			$Graphics.DrawLine($darkPen, 650, 450, 650, 540)
			$Graphics.FillEllipse($accentBrush, 432, 520, 56, 56)
			$Graphics.FillEllipse($accentBrush, 622, 520, 56, 56)
			$Graphics.FillEllipse($white, 792, 422, 56, 56)
		}
		'SPACE' {
			for ($i = 0; $i -lt 18; $i++) {
				$x = (($i * 67) + ($FolderName.Length * 11)) % 760 + 220
				$y = (($i * 43) + ($FolderName.Length * 17)) % 390 + 150
				$Graphics.FillEllipse($white, $x, $y, 8, 8)
			}
			$Graphics.FillEllipse($softWhite, 310, 390, 230, 230)
			$Graphics.DrawArc($whitePen, 275, 420, 310, 110, 7, 170)
			$Graphics.FillPolygon($accentBrush, @(
				(New-Object System.Drawing.Point 710, 210),
				(New-Object System.Drawing.Point 802, 432),
				(New-Object System.Drawing.Point 618, 432)
			))
			$Graphics.FillRectangle($white, 672, 408, 76, 120)
			$Graphics.FillEllipse($shadow, 685, 310, 50, 50)
			$Graphics.FillPolygon($softWhite, @(
				(New-Object System.Drawing.Point 672, 528),
				(New-Object System.Drawing.Point 710, 612),
				(New-Object System.Drawing.Point 748, 528)
			))
		}
		default {
			$Graphics.FillRectangle($softWhite, 235, 450, 730, 145)
			$Graphics.FillEllipse($white, 290, 260, 180, 180)
			$Graphics.FillEllipse($accentBrush, 520, 210, 150, 150)
			$Graphics.FillEllipse($white, 720, 286, 190, 190)
			$Graphics.FillPolygon($shadow, @(
				(New-Object System.Drawing.Point 190, 595),
				(New-Object System.Drawing.Point 424, 360),
				(New-Object System.Drawing.Point 612, 595)
			))
			$Graphics.FillPolygon($softWhite, @(
				(New-Object System.Drawing.Point 520, 595),
				(New-Object System.Drawing.Point 774, 330),
				(New-Object System.Drawing.Point 1010, 595)
			))
		}
	}

	$white.Dispose()
	$softWhite.Dispose()
	$shadow.Dispose()
	$accentBrush.Dispose()
	$darkPen.Dispose()
	$whitePen.Dispose()
	$thinPen.Dispose()
}

$created = 0
$skipped = 0

Get-ChildItem -LiteralPath $gamesRoot -Directory | Sort-Object Name | ForEach-Object {
	$gameDir = $_.FullName
	$folderName = $_.Name
	$gameFile = Join-Path $gameDir 'game.php'
	if (-not (Test-Path -LiteralPath $gameFile)) {
		return
	}

	$outFile = Join-Path $gameDir 'featured-image.png'
	$existing = @(
		'featured-image.png',
		'featured-image.jpg',
		'featured-image.jpeg',
		'featured-image.webp',
		'featured-image.svg'
	) | Where-Object { Test-Path -LiteralPath (Join-Path $gameDir $_) }

	if ($existing.Count -gt 0 -and -not $Force) {
		$skipped++
		return
	}

	$title = Get-TitleFromGameFile -GameFile $gameFile -Fallback $folderName
	$theme = Get-Theme ($folderName + ' ' + $title)
	$from = Convert-HexToColor $theme.From
	$to = Convert-HexToColor $theme.To
	$accent = Convert-HexToColor $theme.Accent

	$bitmap = New-Object System.Drawing.Bitmap $width, $height
	$graphics = [System.Drawing.Graphics]::FromImage($bitmap)
	$graphics.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
	$graphics.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit

	$rect = New-Object System.Drawing.Rectangle 0, 0, $width, $height
	$brush = New-Object System.Drawing.Drawing2D.LinearGradientBrush $rect, $from, $to, 45
	$graphics.FillRectangle($brush, $rect)

	$lightBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(58, 255, 255, 255))
	$darkBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(44, 15, 23, 42))
	for ($i = 0; $i -lt 13; $i++) {
		$x = (($i * 137) + ($folderName.Length * 19)) % ($width + 180) - 90
		$y = (($i * 83) + ($folderName.Length * 31)) % ($height + 180) - 90
		$size = 54 + (($i * 29) % 112)
		$graphics.FillEllipse($(if ($i % 2 -eq 0) { $lightBrush } else { $darkBrush }), $x, $y, $size, $size)
	}

	Draw-GamePicture -Graphics $graphics -Theme $theme -FolderName $folderName -Accent $accent

	$bitmap.Save($outFile, [System.Drawing.Imaging.ImageFormat]::Png)
	Set-Content -LiteralPath (Join-Path $gameDir '.featured-image.generated') -Value 'Generated by zeka-oyunlari/generate-featured-images.ps1' -NoNewline

	$graphics.Dispose()
	$bitmap.Dispose()
	$brush.Dispose()
	$lightBrush.Dispose()
	$darkBrush.Dispose()
	$created++
}

Write-Output "Created $created featured images. Skipped $skipped existing images."
