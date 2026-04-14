def is_valid(board):
    # Check rows
    for i in range(9):
        seen = set()
        for j in range(9):
            if board[i][j] != 0:
                if board[i][j] in seen:
                    return False
                seen.add(board[i][j])
    # Check columns
    for j in range(9):
        seen = set()
        for i in range(9):
            if board[i][j] != 0:
                if board[i][j] in seen:
                    return False
                seen.add(board[i][j])
    # Check boxes
    for box_i in range(3):
        for box_j in range(3):
            seen = set()
            for i in range(3):
                for j in range(3):
                    val = board[box_i*3 + i][box_j*3 + j]
                    if val != 0:
                        if val in seen:
                            return False
                        seen.add(val)
    return True

puzzle = '900050001040003005001900700100500004004090100700001030500200003070300060800040009'
solution = '987654321246173985351928746128537694634892157795461832519286473472319568863745219'

board = [[int(solution[i*9 + j]) for j in range(9)] for i in range(9)]
puzzle_board = [[int(puzzle[i*9 + j]) for j in range(9)] for i in range(9)]

# Check if solution matches puzzle where puzzle has numbers
matches = True
for i in range(9):
    for j in range(9):
        if puzzle_board[i][j] != 0 and puzzle_board[i][j] != board[i][j]:
            matches = False
            print(f"Mismatch at {i},{j}: puzzle {puzzle_board[i][j]}, solution {board[i][j]}")

if matches and is_valid(board):
    print("Solution is valid and matches puzzle")
else:
    print("Solution is invalid")