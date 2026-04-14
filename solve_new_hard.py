def is_valid(board, row, col, num):
    # Check row
    for x in range(9):
        if board[row][x] == num:
            return False
    # Check column
    for x in range(9):
        if board[x][col] == num:
            return False
    # Check box
    start_row = row - row % 3
    start_col = col - col % 3
    for i in range(3):
        for j in range(3):
            if board[i + start_row][j + start_col] == num:
                return False
    return True

def solve_sudoku(board):
    for i in range(9):
        for j in range(9):
            if board[i][j] == 0:
                for num in range(1, 10):
                    if is_valid(board, i, j, num):
                        board[i][j] = num
                        if solve_sudoku(board):
                            return True
                        board[i][j] = 0
                return False
    return True

# New hard puzzle
puzzle = '800000000003600000070090200050007000000045700000100030001000068008500010090000400'
board = [[int(puzzle[i*9 + j]) for j in range(9)] for i in range(9)]

if solve_sudoku(board):
    solution = ''.join(str(board[i][j]) for i in range(9) for j in range(9))
    print(solution)
else:
    print("No solution")