import random

def is_valid(board, row, col, num):
    for x in range(9):
        if board[row][x] == num:
            return False
        if board[x][col] == num:
            return False
    start_row = row - row % 3
    start_col = col - col % 3
    for i in range(3):
        for j in range(3):
            if board[start_row + i][start_col + j] == num:
                return False
    return True

def solve_sudoku(board, solutions_count=[0]):
    if solutions_count[0] > 1:
        return False
    for i in range(9):
        for j in range(9):
            if board[i][j] == 0:
                for num in range(1, 10):
                    if is_valid(board, i, j, num):
                        board[i][j] = num
                        if solve_sudoku(board, solutions_count):
                            return True
                        board[i][j] = 0
                return False
    solutions_count[0] += 1
    return solutions_count[0] == 1

def generate_solution():
    board = [[0]*9 for _ in range(9)]
    nums = list(range(1, 10))
    for i in range(9):
        random.shuffle(nums)
        for j in range(9):
            board[i][j] = nums[j]
    return board

def create_puzzle(difficulty=1):
    solution = generate_solution()
    puzzle = [row[:] for row in solution]
    
    remove_count = {1: 35, 2: 50, 3: 60}[difficulty]
    cells = [(i, j) for i in range(9) for j in range(9)]
    random.shuffle(cells)
    
    for count, (i, j) in enumerate(cells[:remove_count]):
        puzzle[i][j] = 0
    
    puzzle_str = ''.join(str(puzzle[i][j]) for i in range(9) for j in range(9))
    solution_str = ''.join(str(solution[i][j]) for i in range(9) for j in range(9))
    
    return puzzle_str, solution_str

puzzles_by_level = {1: [], 2: [], 3: []}
targets = {1: 350, 2: 350, 3: 300}

for level in [1, 2, 3]:
    print(f'Generating {targets[level]} level {level} puzzles...')
    for _ in range(targets[level]):
        try:
            pu, sol = create_puzzle(level)
            puzzles_by_level[level].append((pu, sol))
        except:
            pass
    print(f'Generated {len(puzzles_by_level[level])} puzzles for level {level}')

with open('puzzles_output.txt', 'w') as f:
    for level, puzzles in puzzles_by_level.items():
        for pu, sol in puzzles:
            f.write(f'{level}|{pu}|{sol}\n')

print('Done! Saved to puzzles_output.txt')
