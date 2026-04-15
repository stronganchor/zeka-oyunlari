with open('puzzles_output.txt', 'r') as f:
    lines = f.readlines()

puzzles = {'1': [], '2': [], '3': []}

for line in lines:
    parts = line.strip().split('|')
    if len(parts) == 3:
        level, puzzle, solution = parts
        puzzles[level].append((puzzle, solution))

output = {}
output['1'] = '\n\t\t\t,\n\t\t\t'.join([f'{{\n\t\t\t\tpuzzle: \'{pu}\',\n\t\t\t\tsolution: \'{sol}\'\n\t\t\t}}' for pu, sol in puzzles['1']])
output['2'] = '\n\t\t\t,\n\t\t\t'.join([f'{{\n\t\t\t\tpuzzle: \'{pu}\',\n\t\t\t\tsolution: \'{sol}\'\n\t\t\t}}' for pu, sol in puzzles['2']])
output['3'] = '\n\t\t\t,\n\t\t\t'.join([f'{{\n\t\t\t\tpuzzle: \'{pu}\',\n\t\t\t\tsolution: \'{sol}\'\n\t\t\t}}' for pu, sol in puzzles['3']])

with open('puzzles_easy.txt', 'w') as f:
    f.write(output['1'])
with open('puzzles_medium.txt', 'w') as f:
    f.write(output['2'])
with open('puzzles_hard.txt', 'w') as f:
    f.write(output['3'])

print(f'Easy: {len(puzzles["1"])} puzzles')
print(f'Medium: {len(puzzles["2"])} puzzles')
print(f'Hard: {len(puzzles["3"])} puzzles')
print('Formatted puzzles saved to puzzles_easy.txt, puzzles_medium.txt, puzzles_hard.txt')
