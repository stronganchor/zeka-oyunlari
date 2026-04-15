with open('puzzles_easy.txt', 'r') as f:
    easy_content = f.read()

with open('puzzles_medium.txt', 'r') as f:
    medium_content = f.read()

with open('puzzles_hard.txt', 'r') as f:
    hard_content = f.read()

easy_js = f"""easy: [
\t\t\t{{
\t\t\t\tpuzzle: '530070000600195000098000060800060003400803001700020006060000280000419005000080079',
\t\t\t\tsolution: '534678912672195348198342567859761423426853791713924856961537284287419635345286179'
\t\t\t}},
\t\t\t{easy_content}
\t\t],"""

medium_js = f"""medium: [
\t\t\t{{
\t\t\t\tpuzzle: '000000907000420180000705026100904000050000040000507009920108000034059000507000000',
\t\t\t\tsolution: '462831957795426183381795426173984265659312748248567319926178534834259671517643892'
\t\t\t}},
\t\t\t{medium_content}
\t\t],"""

hard_js = f"""hard: [
\t\t\t{{
\t\t\t\tpuzzle: '005300000800000020070010500400005300010070006003200080060500009004000030000009700',
\t\t\t\tsolution: '145327698839654127672918543496185372218473956753296481367542819984761235521839764'
\t\t\t}},
\t\t\t{hard_content}
\t\t]"""

with open('puzzle_bank_new.js', 'w') as f:
    f.write(easy_js + '\n')
    f.write(medium_js + '\n')
    f.write(hard_js)

print('Puzzle bank JS code generated: puzzle_bank_new.js')
