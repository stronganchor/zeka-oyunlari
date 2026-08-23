"""Mindsweeper - a 50-level terminal Minesweeper game.

Run with: python mindsweeper.py
Commands: row column [f]   reveal a cell, or add/remove a flag with f
          n                 start a new board
          q                 quit
"""

from __future__ import annotations

import random
import sys
from dataclasses import dataclass, field


LEVELS = 50


@dataclass
class Board:
    level: int
    rows: int
    cols: int
    mines: int
    seed: int
    hidden: set[tuple[int, int]] = field(default_factory=set)
    flagged: set[tuple[int, int]] = field(default_factory=set)
    exploded: tuple[int, int] | None = None
    numbers: list[list[int]] = field(init=False)

    def __post_init__(self) -> None:
        self.numbers = [[0] * self.cols for _ in range(self.rows)]

    def neighbors(self, row: int, col: int):
        for dr in (-1, 0, 1):
            for dc in (-1, 0, 1):
                if not (dr or dc):
                    continue
                nr, nc = row + dr, col + dc
                if 0 <= nr < self.rows and 0 <= nc < self.cols:
                    yield nr, nc

    def build(self, first: tuple[int, int]) -> None:
        safe = {first, *self.neighbors(*first)}
        candidates = [(r, c) for r in range(self.rows) for c in range(self.cols)
                      if (r, c) not in safe]
        rng = random.Random(self.seed)
        mines = set(rng.sample(candidates, min(self.mines, len(candidates))))
        self.hidden = {(r, c) for r in range(self.rows) for c in range(self.cols)}
        self.numbers = [[0] * self.cols for _ in range(self.rows)]
        for mine in mines:
            self.numbers[mine[0]][mine[1]] = -1
            for nr, nc in self.neighbors(*mine):
                if self.numbers[nr][nc] != -1:
                    self.numbers[nr][nc] += 1

    def reveal(self, row: int, col: int) -> bool:
        if (row, col) not in self.hidden or (row, col) in self.flagged:
            return True
        if self.numbers[row][col] == -1:
            self.exploded = (row, col)
            self.hidden.remove((row, col))
            return False
        queue = [(row, col)]
        while queue:
            current = queue.pop()
            if current not in self.hidden or current in self.flagged:
                continue
            self.hidden.remove(current)
            r, c = current
            if self.numbers[r][c] == 0:
                queue.extend(self.neighbors(r, c))
        return True

    def won(self) -> bool:
        return len(self.hidden - self.flagged) == self.mines

    def show(self, reveal_mines: bool = False) -> str:
        colors = {1: "\033[94m", 2: "\033[92m", 3: "\033[91m", 4: "\033[95m",
                  5: "\033[31m", 6: "\033[36m", 7: "\033[33m", 8: "\033[37m"}
        reset = "\033[0m"
        out = [f"\nLevel {self.level}/{LEVELS}  |  {self.rows}x{self.cols}  |  mines: {self.mines}"]
        out.append("    " + " ".join(f"{c + 1:2}" for c in range(self.cols)))
        for r in range(self.rows):
            cells = []
            for c in range(self.cols):
                pos = (r, c)
                if pos in self.flagged:
                    cell = "⚑"
                elif pos in self.hidden and not reveal_mines:
                    cell = "·"
                elif self.numbers[r][c] == -1:
                    cell = "✹"
                elif self.numbers[r][c] == 0:
                    cell = " "
                else:
                    value = str(self.numbers[r][c])
                    cell = colors.get(self.numbers[r][c], "") + value + reset
                cells.append(f"{cell:^2}")
            out.append(f"{r + 1:2}  " + " ".join(cells))
        return "\n".join(out)


def make_board(level: int, seed: int | None = None) -> Board:
    # The board grows every few levels, while mine density rises gradually.
    rows = min(18, 7 + (level - 1) // 7)
    cols = min(26, 9 + (level - 1) // 5)
    mines = min(rows * cols - 9, 8 + level * 2 + (level // 10) * 3)
    return Board(level, rows, cols, mines, seed if seed is not None else random.randrange(1_000_000_000))


def ask_position(text: str, board: Board):
    parts = text.lower().split()
    if len(parts) not in (2, 3):
        raise ValueError("use: row column, or row column f")
    row, col = int(parts[0]) - 1, int(parts[1]) - 1
    if not (0 <= row < board.rows and 0 <= col < board.cols):
        raise ValueError("that cell is outside the board")
    return row, col, len(parts) == 3 and parts[2] == "f"


def play() -> None:
    level = 1
    while level <= LEVELS:
        board = make_board(level)
        first_move = True
        print("\nMINDSWEEPER - clear all 50 levels!")
        while True:
            print(board.show())
            command = input("\nYour move (row column [f], n=new, q=quit): ").strip()
            if command.lower() == "q":
                print("Thanks for playing!")
                return
            if command.lower() == "n":
                board = make_board(level)
                first_move = True
                continue
            try:
                row, col, flag = ask_position(command, board)
            except (ValueError, IndexError):
                print("Please enter two numbers, optionally followed by f.")
                continue
            if first_move:
                board.build((row, col))
                first_move = False
            if flag:
                if (row, col) not in board.hidden:
                    print("That cell is already open.")
                elif (row, col) in board.flagged:
                    board.flagged.remove((row, col))
                elif len(board.flagged) < board.mines:
                    board.flagged.add((row, col))
            elif not board.reveal(row, col):
                print(board.show(reveal_mines=True))
                print(f"Boom! You reached level {level}. Try it again.")
                break
            if board.won():
                print(board.show())
                print(f"Level {level} cleared!")
                level += 1
                if level <= LEVELS:
                    input("Press Enter for the next level...")
                break
    print("\n🏆 Amazing! You completed all 50 Mindsweeper levels!")


if __name__ == "__main__":
    try:
        play()
    except (KeyboardInterrupt, EOFError):
        print("\nGame closed.")
        sys.exit(0)
