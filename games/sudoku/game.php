<?php

if (!defined('ABSPATH')) {
	exit;
}

$css = <<<'CSS'
.zo-game-root.zo-game-root--sudoku { max-width: 1120px; margin: 0 auto; padding: 20px; box-sizing: border-box; font-family: "Trebuchet MS", "Segoe UI", sans-serif; color: #1d2a3a; }
.zo-game-root--sudoku .zo-sudoku { padding: 22px; border-radius: 28px; background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.9), transparent 24%), linear-gradient(180deg, #eef7ff 0%, #d8ebff 100%); border: 1px solid #bfd7ef; box-shadow: 0 18px 40px rgba(36, 76, 120, 0.15); }
.zo-game-root--sudoku .zo-sudoku__hero { display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 18px; margin-bottom: 18px; }
.zo-game-root--sudoku .zo-sudoku__eyebrow { margin: 0 0 6px; font-size: 12px; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: #ab5a16; }
.zo-game-root--sudoku .zo-sudoku__title { margin: 0 0 8px; font-size: clamp(34px, 5vw, 48px); line-height: 0.95; }
.zo-game-root--sudoku .zo-sudoku__intro { max-width: 680px; margin: 0; font-size: 15px; line-height: 1.6; color: #45617d; }
.zo-game-root--sudoku .zo-sudoku__stats { display: grid; grid-template-columns: repeat(4, minmax(110px, 1fr)); gap: 12px; min-width: min(100%, 360px); }
.zo-game-root--sudoku .zo-sudoku__stat, .zo-game-root--sudoku .zo-sudoku__card, .zo-game-root--sudoku .zo-sudoku__board-panel { background: rgba(255, 255, 255, 0.82); border: 1px solid rgba(110, 148, 188, 0.22); border-radius: 20px; }
.zo-game-root--sudoku .zo-sudoku__stat { padding: 14px 16px; text-align: center; }
.zo-game-root--sudoku .zo-sudoku__stat-label { display: block; margin-bottom: 4px; font-size: 11px; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; color: #64819d; }
.zo-game-root--sudoku .zo-sudoku__stat-value { font-size: 26px; line-height: 1; }
.zo-game-root--sudoku .zo-sudoku__toolbar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 18px; }
.zo-game-root--sudoku .zo-sudoku__difficulty-label { display: inline-flex; align-items: center; gap: 10px; font-weight: 700; color: #34516f; }
.zo-game-root--sudoku .zo-sudoku__difficulty { min-height: 42px; padding: 0 14px; border: 1px solid #b9cee3; border-radius: 999px; background: #fff; color: #1d2a3a; font: inherit; }
.zo-game-root--sudoku .zo-sudoku__actions { display: flex; flex-wrap: wrap; gap: 10px; }
.zo-game-root--sudoku .zo-sudoku__button, .zo-game-root--sudoku .zo-sudoku__key { border: 0; border-radius: 999px; background: #e4eef9; color: #1d2a3a; cursor: pointer; font: inherit; font-weight: 800; transition: transform 0.12s ease, background 0.12s ease, box-shadow 0.12s ease; }
.zo-game-root--sudoku .zo-sudoku__button { min-height: 44px; padding: 0 18px; }
.zo-game-root--sudoku .zo-sudoku__button:hover, .zo-game-root--sudoku .zo-sudoku__button:focus-visible, .zo-game-root--sudoku .zo-sudoku__key:hover, .zo-game-root--sudoku .zo-sudoku__key:focus-visible { transform: translateY(-1px); outline: none; box-shadow: 0 10px 20px rgba(49, 88, 130, 0.12); }
.zo-game-root--sudoku .zo-sudoku__button--primary { background: linear-gradient(180deg, #1f73c9 0%, #1459a0 100%); color: #fff; }
.zo-game-root--sudoku .zo-sudoku__button.is-active { background: linear-gradient(180deg, #1f7a5a 0%, #14543f 100%); color: #fff; }
.zo-game-root--sudoku .zo-sudoku__layout { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(280px, 0.8fr); gap: 18px; }
.zo-game-root--sudoku .zo-sudoku__board-panel { padding: 18px; }
.zo-game-root--sudoku .zo-sudoku__board { display: grid; grid-template-columns: repeat(9, minmax(0, 1fr)); width: min(100%, 620px); margin: 0 auto; border: 4px solid #284766; border-radius: 18px; overflow: hidden; background: #284766; }
.zo-game-root--sudoku .zo-sudoku__cell { position: relative; display: grid; place-items: center; aspect-ratio: 1 / 1; min-width: 0; border: 1px solid #acc7dc; background: #fbfdff; color: #203246; font-size: clamp(20px, 2.7vw, 30px); font-weight: 800; cursor: pointer; }
.zo-game-root--sudoku .zo-sudoku__cell.is-given { background: linear-gradient(180deg, #d8ecff 0%, #c7e2fa 100%); color: #113b63; cursor: default; }
.zo-game-root--sudoku .zo-sudoku__cell.is-noted { align-items: stretch; justify-content: stretch; padding: 4px; }
.zo-game-root--sudoku .zo-sudoku__cell.is-selected { background: #fff3c4; }
.zo-game-root--sudoku .zo-sudoku__cell.is-related { background: #edf6ff; }
.zo-game-root--sudoku .zo-sudoku__cell.is-given.is-related { background: linear-gradient(180deg, #d3e8fb 0%, #bdddf8 100%); }
.zo-game-root--sudoku .zo-sudoku__cell.is-conflict { background: #ffe0e0; color: #9a1f1f; }
.zo-game-root--sudoku .zo-sudoku__cell[data-col="2"], .zo-game-root--sudoku .zo-sudoku__cell[data-col="5"] { border-right: 3px solid #284766; }
.zo-game-root--sudoku .zo-sudoku__cell[data-row="2"], .zo-game-root--sudoku .zo-sudoku__cell[data-row="5"] { border-bottom: 3px solid #284766; }
.zo-game-root--sudoku .zo-sudoku__cell[data-col="2"][data-row="2"], .zo-game-root--sudoku .zo-sudoku__cell[data-col="5"][data-row="2"], .zo-game-root--sudoku .zo-sudoku__cell[data-col="2"][data-row="5"], .zo-game-root--sudoku .zo-sudoku__cell[data-col="5"][data-row="5"] { border-right: 3px solid #284766; border-bottom: 3px solid #284766; }
.zo-game-root--sudoku .zo-sudoku__notes { display: grid; grid-template-columns: repeat(3, 1fr); width: 100%; height: 100%; gap: 2px; align-items: center; justify-items: center; font-size: clamp(9px, 1.5vw, 12px); font-weight: 700; line-height: 1; color: #4e6882; }
.zo-game-root--sudoku .zo-sudoku__note { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; }
.zo-game-root--sudoku .zo-sudoku__keypad { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 10px; max-width: 600px; margin: 16px auto 0; }
.zo-game-root--sudoku .zo-sudoku__key { min-height: 48px; font-size: 18px; }
.zo-game-root--sudoku .zo-sudoku__key--wide { grid-column: span 2; }
.zo-game-root--sudoku .zo-sudoku__side { display: grid; gap: 14px; }
.zo-game-root--sudoku .zo-sudoku__card { padding: 18px; }
.zo-game-root--sudoku .zo-sudoku__card-title { margin: 0 0 10px; font-size: 18px; }
.zo-game-root--sudoku .zo-sudoku__rules { margin: 0; padding-left: 18px; color: #45617d; line-height: 1.6; }
.zo-game-root--sudoku .zo-sudoku__card-copy, .zo-game-root--sudoku .zo-sudoku__status { margin: 0; font-size: 15px; line-height: 1.6; color: #45617d; }
.zo-game-root--sudoku .zo-sudoku__status { padding: 16px 18px; border-radius: 18px; background: rgba(255, 255, 255, 0.82); border: 1px solid rgba(110, 148, 188, 0.22); font-weight: 700; }
.zo-game-root--sudoku .zo-sudoku__status.is-success { color: #166534; background: #ecfdf3; border-color: #9fd2b0; }
.zo-game-root--sudoku .zo-sudoku__status.is-warning { color: #9a3412; background: #fff7ed; border-color: #f2c59d; }
@media (max-width: 900px) { .zo-game-root--sudoku .zo-sudoku__layout { grid-template-columns: 1fr; } }
@media (max-width: 640px) { .zo-game-root.zo-game-root--sudoku { padding: 12px; } .zo-game-root--sudoku .zo-sudoku { padding: 14px; border-radius: 22px; } .zo-game-root--sudoku .zo-sudoku__stats { grid-template-columns: 1fr 1fr 1fr; min-width: 100%; } .zo-game-root--sudoku .zo-sudoku__board-panel { padding: 12px; } .zo-game-root--sudoku .zo-sudoku__keypad { gap: 8px; } }
CSS;

$js = <<<'JS'
document.addEventListener('DOMContentLoaded', function () {
	const games = document.querySelectorAll('.zo-game-root--sudoku');

	const puzzleBank = {
		easy: [
			{
				puzzle: '530070000600195000098000060800060003400803001700020006060000280000419005000080079',
				solution: '534678912672195348198342567859761423426853791713924856961537284287419635345286179'
			},
			{
				puzzle: '200080300060070084030500209000105408000000000402706000301007040720040060004010003',
				solution: '245981376169273584837564219976125438513498627482736951391657842728349165654812793'
			},
			{
				puzzle: '000260701680070090190004500820100040004602900050003028009300074040050036703018000',
				solution: '435269781682571493197834562826195347374682915951743628519326874248957136763418259'
			},
			{
				puzzle: '003020600900305001001806400008102900700000008006708200002609500800203009005010300',
				solution: '483921657967345821251876493548132976729564138136798245372689514814253769695417382'
			},
			{
				puzzle: '020030006005000900000005008008000300000001000007000600900800000006000200400070010',
				solution: '124938576385167924769245138218456397693781452547392681931824765876513249452679813'
			},
			{
				puzzle: '500293060200604008681590027803601402050607290210700894020098704506007008906500030',
				solution: '578293164295674318681594327893651472358647291215736894123698754516927348976581234'
			},
			{
				puzzle: '400007500300510406084200060840391750706198425002058900385420016000000209612403050',
				solution: '416327589378519426984251763846391752736198425172658943385427916645873219612483759'
			},
			{
				puzzle: '604000158261370900070610002420583006402360009178200300040652010963007201800096100',
				solution: '674392158261374985578613942429583176482367519178295346843652719963487251843796125'
			},
			{
				puzzle: '200005074400502108250010749659370802873091020080005403000708053000300507561480039',
				solution: '231895674476532198253816749659374812873591426786215493942718653241389567561487239'
			},
			{
				puzzle: '021500697036954000200003000100300087081205970007146239041706500830250000749031028',
				solution: '421538697836954217254683197154326987381245976857146239341796582834256791749531628'
			},
			{
				puzzle: '256930074029000860000080069200609087250000183000509106183070960080461025200497806',
				solution: '256938174129754863341287569245619387257649183472539186183574962387461925235497816'
			},
			{
				puzzle: '036400820568040900234007006000900508820064057009172836005014090369007018126009008',
				solution: '136479825568741923234857196647912538821364957549172836235714698369527418126549378'
			},
			{
				puzzle: '087209045000904206410028930640570002000230790894000175071508490031090640020860500',
				solution: '187269345837914256416528937648571392851234796894623175371528496531298647724861593'
			},
			{
				puzzle: '900000103078905140010050030971300006092317080673058120000600802805640709028016943',
				solution: '962485173378965142419657832971358426692317584673458129415637892815643729728516943'
			},
			{
				puzzle: '000027000854603109003180007203001070390075286270000049720985060438005000950816743',
				solution: '619427538854673129953184267243691578394175286278153649724985361438695172952816743'
			},
			{
				puzzle: '070409618140060090050236091826007350000107389020851070326410509967000000802003005',
				solution: '372459618148763295854236791826917354654127389423851976326417589967451238842693715'
			},
			{
				puzzle: '609053080703980400000100360023060908600001800730906402091536704085400672365402080',
				solution: '679153482753981462792154368723164958654721839738916452891536724985431672365492187'
			},
			{
				puzzle: '064001329390100720895003040070423089376900100407503802845002310002380090004501000',
				solution: '764851329394168725895163247576423189376954182497513862845972316162384597834561729'
			},
			{
				puzzle: '007260850014000302975130802000002316030085200000040519042698531034180070602000387',
				solution: '417263859914657382975136842789452316134685297768342519742698531234186975612945387'
			},
			{
				puzzle: '357090012263000409023160040003580214405010007007823054320060018804901002070805040',
				solution: '357698412263185479723168549673589214495618237617823954327569418864971532279815346'
			},
			{
				puzzle: '205006408690000830057060108804690702016280070286047195082007051079060000918002700',
				solution: '275916438697512834257469138854691732916285473286347195382467951579263184918452736'
			},
			{
				puzzle: '782650394407300890020016953350790264058264013093007000000950000000163080100302008',
				solution: '782651394417325896428716953358791264958264713593127486782956431745163982156342978'
			},
			{
				puzzle: '000100490003546918805710304204050080450107902384910026000930850143507000040195000',
				solution: '835172496273546918895716324234157986458137962384915726164937852143587692247195683'
			},
			{
				puzzle: '072390640600050348608003502070080520073095000070041590428135009000530940002701534',
				solution: '872395641627159348618493572673189524473895216678341592428135679782536941982761534'
			},
			{
				puzzle: '403076500402365009010630097300027006795612300901030204610724500803005490000043002',
				solution: '423176598472365819815634297381527946795612384971835264619724538863175492986143572'
			},
			{
				puzzle: '390804700024357680078009300210475800006098100000013050530042068047036512000501073',
				solution: '395864721124357689678129345213475896456298137789613254531742968847936512962581473'
			},
			{
				puzzle: '800000010004358000560029048215436800346890025080000436400762051652041000000580264',
				solution: '893674512124358679567129348215436897346897125789215436438762951652941783971583264'
			},
			{
				puzzle: '302600000106209048009000250203465789467001523000000400020583970874012635030046010',
				solution: '342658197156279348789134256213465789467891523598327461621583974874912635935746812'
			},
			{
				puzzle: '051300980300700120700125346003450098460897013897003564002600009630900050978500000',
				solution: '251364987346789125789125346123456798465897213897213564512638479634971852978542631'
			},
			{
				puzzle: '060254093204000500070308104023005079006000300708603005012846957605037200940502836',
				solution: '861254793234179568579368124123485679456791382798623415312846957685937241947512836'
			}
		],
		medium: [
			{
				puzzle: '000000907000420180000705026100904000050000040000507009920108000034059000507000000',
				solution: '462831957795426183381795426173984265659312748248567319926178534834259671517643892'
			},
			{
				puzzle: '300000000005009000200504000020000700160000058704310600000890100000067080000005437',
				solution: '397681524645279813218534976823956741169742358754318692472893165531467289986125437'
			},
			{
				puzzle: '000900002050123400030000160908000000070000090000000205091000050007439020400007000',
				solution: '814976532659123478732854169948265317275341896163798245391682754587439621426517983'
			},
			{
				puzzle: '000158000002060800030000040027030510000000000046080790050000080004070100000325000',
				solution: '469158372712463859538297641927634518385719426146582793653941287294876135871325964'
			},
			{
				puzzle: '079604050000409100060000000001000057401570690100007002700608000758060000020030050',
				solution: '179684352675489123468927153961423857421573698183967452792638154758462319921638457'
			},
			{
				puzzle: '000010006240700000000357060800000009000952746021048509090040380100000080026000000',
				solution: '248719356243798561421357968813247569831952746621748539695247381126395784926738145'
			},
			{
				puzzle: '608000900010004003038000704050470609007050400507000010800105007230070040370000000',
				solution: '658731924218794563538129764352478619927153468567432918869145237235678941375426918'
			},
			{
				puzzle: '004007800540080310004208090900054060010000006601200040000420000001800600084000067',
				solution: '394657812546982317654278193931254768913824576681237549861429375341897652284135967'
			},
			{
				puzzle: '861000043020006000609010020000300542605940000003000004071000083003409050300010000',
				solution: '861275943328516947679514328198367542685941372293158764271459683673429851386715294'
			},
			{
				puzzle: '372159680000405000009002005600010007205000467000001300000000065000000317301000020',
				solution: '372159684276435891369172485649315827285193467827491365924783165658942317381476529'
			},
			{
				puzzle: '084000060000100920470001000000048927300582009000300080012790000090800603040100000',
				solution: '184279365834165927476231895153648927371582649417325689612795834492871653749185362'
			},
			{
				puzzle: '090100000241000090000306140901005300207005910600300900000080000621900037000001004',
				solution: '295163784241738596875396142981625374287435916672385914152387964621984537692581734'
			},
			{
				puzzle: '070493020000854260000000070000003506500000000000028300000184000020093850000603947',
				solution: '175493826931854267596148273912473586562891437651428397597184362724193856582613947'
			},
			{
				puzzle: '000506890000510000085000093009600703049003006000000000090300020527490081300028000',
				solution: '127546893769512834485621793149652783149583726537869241796348125527493681379528416'
			},
			{
				puzzle: '010080930000630001004001000036800007007060080724039560010000802008070000204000600',
				solution: '615284937294635781764381295236819547397462581724839561519674832458271369234719658'
			},
			{
				puzzle: '860490000000800013500600890000050001000204005063805200068000200495030000800030600',
				solution: '861497253759824613532671894794256831689214375163845297468537219495237681894235671'
			},
			{
				puzzle: '620500030000030078700060000900002000040280009010800700050860049074018030040720000',
				solution: '624581937261539478743962158931482576746283159319826754157863249574918236345728961'
			},
			{
				puzzle: '000004370090200000000000920090000278007050000007040900089470000400053278100092470',
				solution: '852614379198247365147386925591346278937854612367845921189475326419653278153692478'
			},
			{
				puzzle: '700008600000000031145009372000000304007010000013000069801000073600040090816000300',
				solution: '741528693487952631145689372198576324247619835413258769821569473652743198816572394'
			},
			{
				puzzle: '500080006760080000800000607084097006020900000900580000000004201739800000531008600',
				solution: '541782936762489351829534617584297316521948763946587312863594271739821564531298647'
			},
			{
				puzzle: '000800000000003800070100295930000500715006430000109400806007003095400803009020000',
				solution: '561824973194253876374168295931672584715926438875139426896147523695421873859124673'
			},
			{
				puzzle: '000000900700480260000801940000326000080072040300080072502081000980001020000200100',
				solution: '421863957753481269273861945471326958985372146396481572542981763983471526364287195'
			},
			{
				puzzle: '008000000570030018009700000700340020627100000005600048300050000000790326803010004',
				solution: '128365497579632418439728651769348521627135984935627148372659481415798326893612574'
			},
			{
				puzzle: '070080090080000004002090000504000080085100000904000600010680900061020043030749105',
				solution: '475381296985736214482197356524693187785162394924183675712683954761529843238749165'
			},
			{
				puzzle: '570003004204000008689057103000500089050700200090030000012600090005000300000005602',
				solution: '571823964234169578689457123123546789456798231798231456312674895865912347947385612'
			},
			{
				puzzle: '009723000200008009070000003023540000050800001000031046040070980000900304085010700',
				solution: '619723458234158679578469123123546897456897231897231546341672985762985314985314762'
			},
			{
				puzzle: '617090050004050009080007006020005097050789010090300000000000070860970020900500030',
				solution: '617894352234156789589237146123465897456789213798312465345621978861973524972548631'
			}
		],
		hard: [
			{
				puzzle: '005300000800000020070010500400005300010070006003200080060500009004000030000009700',
				solution: '145327698839654127672918543496185372218473956753296481367542819984761235521839764'
			},
			{
				puzzle: '000000000000003085001020000000507000004000100090000000500000073002010000000040009',
				solution: '987654321246173985351928746128537694634892157795461832519286473472319568863745219'
			},
			{
				puzzle: '003502900000040000106000305900251008070408030800763001308000104000020000005104800',
				solution: '743512986589346217126987345934251768671498532852763491398675124417829653265134879'
			},
			{
				puzzle: '235001006200000700001370000000593000000002000405000200008000000400000000000340000',
				solution: '235871946259413786641375928872593641169382475465917238618432597483975261592346781'
			},
			{
				puzzle: '080076005000000050056407030000800019000000000000030000400690000600000058000001000',
				solution: '283476915379842651956487231543826719128579634156437829417692358624913758247631895'
			},
			{
				puzzle: '004902300005000060400000000800041700900000600070020100005301800000000000700000000',
				solution: '614952378715429863452678193892541736958217643475329186265371894165738942718459263'
			},
			{
				puzzle: '002000418009800000690000000007000000290003016000100007000200000060000500008000040',
				solution: '972356418429815673698217534257361984298543716653182497687291345364129578238951647'
			},
			{
				puzzle: '000000007000000000000006001000037009000073000702605000000409080000090085000480900',
				solution: '824561937598746132549826371581637249496873512782695431213479685327491685125487963'
			},
			{
				puzzle: '000004000080000600040000208028000007040000000000900361020300000100002000050000097',
				solution: '612574983287134695546913278528396147348762195542987361124395678148362957851264397'
			},
			{
				puzzle: '000000070000001200008900500007000000050600000002570014000804000000000905005004002',
				solution: '459362871375841269638971542417635289754618329382579614319824756738416925975164832'
			},
			{
				puzzle: '800000000000000000010000000560000074002060900840500907047100000000500000002300070',
				solution: '863517429473612859619532487563289174542768931842563917647159823278549316652394178'
			},
			{
				puzzle: '000080000000600002100500000080006020902070040008607000000000904300040001000000400',
				solution: '479286153415683972134562789481976523952176843528697314123586974369542781283716495'
			},
			{
				puzzle: '000060000906070010403976000400100000075080000070080000600000005000000000900800000',
				solution: '512964378926378514483976521472169385175684923374982615632471895631528497931842675'
			},
			{
				puzzle: '000600000000000019005430906000000002000000000090000000075160200000030000050197600',
				solution: '842675319286537419825431976376814952719345826798152634975163248497835261258197634'
			},
			{
				puzzle: '002100006704000000070890000902000000300000005004000610072030000000080000060090000',
				solution: '432197856714683952172896534932548617394271685354972618572138649726389514167294835'
			},
			{
				puzzle: '000060000730109020800030000000000090000000001038006000001000000600030040203400010',
				solution: '239467815734169528849135672521876394396742581138456279681352947679135248283476915'
			},
			{
				puzzle: '200000804008046000740030100000700002000000400080500000000670804900000000000000080',
				solution: '269517834238746519746538192643789512297168435483572619319672854964172385923765481'
			},
			{
				puzzle: '100800020000300000009000600000000000000073005005006800590000400004100000402300500',
				solution: '143876925971326584359482671842935167462173895245396871596182473834196752462389517'
			},
			{
				puzzle: '078591200000000000060200000200000000056780000007100006030800000080000000040000800',
				solution: '378591264124367589569248137213456798456789312897123456631872945785914623942635871'
			},
			{
				puzzle: '000000300020008000000030200210050700050807000000014030000001800001000900002003000',
				solution: '497625381123478569568139247214356798356897124789214635635941872841762953972583416'
			}
		]
	};

	function getBoxIndex(row, col) {
		return Math.floor(row / 3) * 3 + Math.floor(col / 3);
	}

	function toCells(value) {
		return value.split('');
	}

	function formatTime(totalSeconds) {
		const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
		const secs = String(totalSeconds % 60).padStart(2, '0');
		return mins + ':' + secs;
	}

	function pickPuzzle(level, usedIndexes) {
		const list = puzzleBank[level] || puzzleBank.easy;
		const available = list.map(function (_, index) {
			return index;
		}).filter(function (index) {
			return !usedIndexes.includes(index);
		});
		const choices = available.length ? available : list.map(function (_, index) {
			return index;
		});
		const choice = choices[Math.floor(Math.random() * choices.length)];
		return { index: choice, data: list[choice] };
	}

	function setStatus(statusEl, message, type) {
		statusEl.textContent = message;
		statusEl.classList.remove('is-success', 'is-warning');

		if (type === 'success') {
			statusEl.classList.add('is-success');
		} else if (type === 'warning') {
			statusEl.classList.add('is-warning');
		}
	}

	function collectConflicts(board) {
		const conflicts = new Set();

		function scan(group) {
			const seen = {};

			group.forEach(function (index) {
				const value = board[index];
				if (!value || value === '0') {
					return;
				}
				if (!seen[value]) {
					seen[value] = [];
				}
				seen[value].push(index);
			});

			Object.keys(seen).forEach(function (value) {
				if (seen[value].length > 1) {
					seen[value].forEach(function (index) {
						conflicts.add(index);
					});
				}
			});
		}

		for (let row = 0; row < 9; row += 1) {
			scan(Array.from({ length: 9 }, function (_, col) {
				return row * 9 + col;
			}));
		}

		for (let col = 0; col < 9; col += 1) {
			scan(Array.from({ length: 9 }, function (_, row) {
				return row * 9 + col;
			}));
		}

		for (let boxRow = 0; boxRow < 3; boxRow += 1) {
			for (let boxCol = 0; boxCol < 3; boxCol += 1) {
				const group = [];
				for (let row = 0; row < 3; row += 1) {
					for (let col = 0; col < 3; col += 1) {
						group.push((boxRow * 3 + row) * 9 + (boxCol * 3 + col));
					}
				}
				scan(group);
			}
		}

		return conflicts;
	}

	games.forEach(function (game) {
		const boardEl = game.querySelector('[data-role="board"]');
		const keypadEl = game.querySelector('[data-role="keypad"]');
		const difficultyEl = game.querySelector('[data-role="difficulty"]');
		const filledEl = game.querySelector('[data-role="filled"]');
		const mistakesEl = game.querySelector('[data-role="mistakes"]');
		const timerEl = game.querySelector('[data-role="timer"]');
		const statusEl = game.querySelector('[data-role="status"]');
		const bestTimeEl = game.querySelector('[data-role="best-time"]');
		const newBtn = game.querySelector('[data-action="new"]');
		const notesBtn = game.querySelector('[data-action="notes"]');
		const resetBtn = game.querySelector('[data-action="reset"]');
		const checkBtn = game.querySelector('[data-action="check"]');
		const hintBtn = game.querySelector('[data-action="hint"]');
		const undoBtn = game.querySelector('[data-action="undo"]');

		let board = [];
		let startBoard = [];
		let solution = [];
		let notes = [];
		let selectedIndex = -1;
		let mistakes = 0;
		let seconds = 0;
		let timerId = null;
		let solved = false;
		let noteMode = false;
		let history = [];
		let bestKey = '';
		const usedByLevel = {
			easy: [],
			medium: [],
			hard: []
		};

		function startTimer() {
			window.clearInterval(timerId);
			timerId = window.setInterval(function () {
				seconds += 1;
				timerEl.textContent = formatTime(seconds);
			}, 1000);
		}

		function updateStats() {
			const filled = board.filter(function (value) {
				return value !== '0';
			}).length;
			filledEl.textContent = filled + ' / 81';
			mistakesEl.textContent = String(mistakes);
		}

		function updateNotesButton() {
			notesBtn.textContent = noteMode ? 'Notes: On' : 'Notes: Off';
			notesBtn.classList.toggle('is-active', noteMode);
			notesBtn.setAttribute('aria-pressed', noteMode ? 'true' : 'false');
		}

		function renderCellContent(cell, index) {
			const value = board[index];
			const noteList = notes[index] || [];

			if (value !== '0') {
				cell.textContent = value;
				cell.classList.remove('is-noted');
				return;
			}

			if (!noteList.length) {
				cell.textContent = '';
				cell.classList.remove('is-noted');
				return;
			}

			const noteGrid = document.createElement('span');
			noteGrid.className = 'zo-sudoku__notes';

			for (let digit = 1; digit <= 9; digit += 1) {
				const note = document.createElement('span');
				note.className = 'zo-sudoku__note';
				note.textContent = noteList.includes(String(digit)) ? String(digit) : '';
				noteGrid.appendChild(note);
			}

			cell.replaceChildren(noteGrid);
			cell.classList.add('is-noted');
		}

		function renderSelection() {
			const selectedRow = selectedIndex >= 0 ? Math.floor(selectedIndex / 9) : -1;
			const selectedCol = selectedIndex >= 0 ? selectedIndex % 9 : -1;
			const selectedBox = selectedIndex >= 0 ? getBoxIndex(selectedRow, selectedCol) : -1;
			const conflicts = collectConflicts(board);

			Array.from(boardEl.children).forEach(function (cell, index) {
				const row = Math.floor(index / 9);
				const col = index % 9;

				renderCellContent(cell, index);
				cell.classList.toggle('is-selected', index === selectedIndex);
				cell.classList.toggle('is-related', selectedIndex >= 0 && index !== selectedIndex && (row === selectedRow || col === selectedCol || getBoxIndex(row, col) === selectedBox));
				cell.classList.toggle('is-conflict', conflicts.has(index));
				cell.classList.remove('is-wrong');
			});
		}

		function markWrongCells() {
			let wrongCount = 0;

			Array.from(boardEl.children).forEach(function (cell, index) {
				const value = board[index];
				const wrong = value !== '0' && value !== solution[index];
				cell.classList.toggle('is-wrong', wrong);
				if (wrong) {
					wrongCount += 1;
				}
			});

			return wrongCount;
		}

		function checkWin() {
			const done = board.every(function (value, index) {
				return value === solution[index];
			});

			if (!done || solved) {
				return;
			}

			solved = true;
			window.clearInterval(timerId);
			setStatus(statusEl, 'Puzzle solved. Every row, column, and box is correct.', 'success');

			const best = localStorage.getItem(bestKey);
			if (!best || seconds < parseInt(best, 10)) {
				localStorage.setItem(bestKey, String(seconds));
				bestTimeEl.textContent = formatTime(seconds);
			}
		}

		function applyValue(rawValue) {
			if (selectedIndex < 0 || solved) {
				return;
			}

			const cell = boardEl.children[selectedIndex];
			if (!cell || cell.dataset.given === '1') {
				return;
			}

			const value = String(rawValue);
			if (!/^[0-9]$/.test(value)) {
				return;
			}

			if (noteMode) {
				if (board[selectedIndex] !== '0') {
					setStatus(statusEl, 'Clear the final number first if you want to add candidates to this square.', 'warning');
					return;
				}

				if (value === '0') {
					notes[selectedIndex] = [];
					renderSelection();
					setStatus(statusEl, 'Notes cleared from the selected square.', '');
					return;
				}

				const currentNotes = notes[selectedIndex] || [];
				if (currentNotes.includes(value)) {
					notes[selectedIndex] = currentNotes.filter(function (entry) {
						return entry !== value;
					});
					setStatus(statusEl, 'Candidate ' + value + ' removed from the selected square.', '');
				} else {
					notes[selectedIndex] = currentNotes.concat(value).sort();
					setStatus(statusEl, 'Candidate ' + value + ' added to the selected square.', '');
				}

				renderSelection();
				updateStats();
				return;
			}

			if (value !== board[selectedIndex]) {
				history.push({ index: selectedIndex, oldValue: board[selectedIndex], oldNotes: notes[selectedIndex].slice() });
			}

			board[selectedIndex] = value === '0' ? '0' : value;
			notes[selectedIndex] = [];
			renderSelection();
			updateStats();

			if (value === '0') {
				setStatus(statusEl, 'Square cleared.', '');
			} else {
				setStatus(statusEl, 'Placed ' + value + '. Keep each row, column, and 3x3 box unique.', '');
			}

			checkWin();
		}

		function buildBoard() {
			boardEl.innerHTML = '';

			for (let index = 0; index < 81; index += 1) {
				const row = Math.floor(index / 9);
				const col = index % 9;
				const button = document.createElement('button');
				button.type = 'button';
				button.className = 'zo-sudoku__cell';
				button.dataset.index = String(index);
				button.dataset.row = String(row);
				button.dataset.col = String(col);
				button.dataset.given = startBoard[index] === '0' ? '0' : '1';

				if (startBoard[index] !== '0') {
					button.classList.add('is-given');
					button.textContent = startBoard[index];
				}

				button.addEventListener('click', function () {
					selectedIndex = index;
					renderSelection();
				});

				boardEl.appendChild(button);
			}

			renderSelection();
		}

		function loadPuzzle() {
			const level = difficultyEl.value;
			const selection = pickPuzzle(level, usedByLevel[level]);
			usedByLevel[level].push(selection.index);
			if (usedByLevel[level].length > (puzzleBank[level] || []).length) {
				usedByLevel[level].shift();
			}

			bestKey = 'sudoku-best-' + level;
			const best = localStorage.getItem(bestKey);
			bestTimeEl.textContent = best ? formatTime(parseInt(best, 10)) : '--:--';

			startBoard = toCells(selection.data.puzzle);
			solution = toCells(selection.data.solution);
			board = startBoard.slice();
			notes = Array.from({ length: 81 }, function () { return []; });
			selectedIndex = -1;
			mistakes = 0;
			seconds = 0;
			solved = false;
			history = [];
			noteMode = false;
			timerEl.textContent = '00:00';
			setStatus(statusEl, 'New ' + level + ' puzzle ready. Choose an empty square to begin.', '');
			updateNotesButton();
			buildBoard();
			updateStats();
			startTimer();
		}

		function resetPuzzle() {
			board = startBoard.slice();
			notes = Array.from({ length: 81 }, function () { return []; });
			selectedIndex = -1;
			solved = false;
			history = [];
			renderSelection();
			updateStats();
			setStatus(statusEl, 'Puzzle reset to the starting clues.', '');
		}

		keypadEl.addEventListener('click', function (event) {
			const key = event.target.closest('[data-value]');
			if (!key) {
				return;
			}
			applyValue(key.dataset.value || '0');
		});

		game.addEventListener('keydown', function (event) {
			if (selectedIndex < 0) {
				return;
			}

			if (/^[1-9]$/.test(event.key)) {
				event.preventDefault();
				applyValue(event.key);
				return;
			}

			if (event.key === 'Backspace' || event.key === 'Delete' || event.key === '0') {
				event.preventDefault();
				applyValue('0');
				return;
			}

			if (event.key === 'ArrowUp' && selectedIndex >= 9) {
				event.preventDefault();
				selectedIndex -= 9;
				renderSelection();
			} else if (event.key === 'ArrowDown' && selectedIndex <= 71) {
				event.preventDefault();
				selectedIndex += 9;
				renderSelection();
			} else if (event.key === 'ArrowLeft' && selectedIndex % 9 !== 0) {
				event.preventDefault();
				selectedIndex -= 1;
				renderSelection();
			} else if (event.key === 'ArrowRight' && selectedIndex % 9 !== 8) {
				event.preventDefault();
				selectedIndex += 1;
				renderSelection();
			}
		});

		newBtn.addEventListener('click', loadPuzzle);
		notesBtn.addEventListener('click', function () {
			noteMode = !noteMode;
			updateNotesButton();
			setStatus(statusEl, noteMode ? 'Notes mode is on. Added numbers will appear as small candidates.' : 'Notes mode is off. Added numbers will be final answers.', '');
		});
		resetBtn.addEventListener('click', resetPuzzle);
		checkBtn.addEventListener('click', function () {
			if (solved) {
				setStatus(statusEl, 'This puzzle is already solved.', 'success');
				return;
			}

			renderSelection();
			const wrongCount = markWrongCells();

			if (wrongCount > 0) {
				mistakes += wrongCount;
				updateStats();
				setStatus(statusEl, wrongCount + ' square(s) do not match the solution yet.', 'warning');
				return;
			}

			if (board.includes('0')) {
				setStatus(statusEl, 'So far so good. The remaining empty squares are still waiting.', '');
				return;
			}

			checkWin();
		});

		hintBtn.addEventListener('click', function () {
			if (solved) {
				setStatus(statusEl, 'You already solved it.', 'success');
				return;
			}

			let target = selectedIndex;
			if (target < 0 || startBoard[target] !== '0') {
				target = board.findIndex(function (value, index) {
					return value === '0' && startBoard[index] === '0';
				});
			}

			if (target < 0) {
				setStatus(statusEl, 'There are no empty squares left for a hint.', '');
				return;
			}

			history.push({ index: target, oldValue: board[target], oldNotes: notes[target].slice() });

			board[target] = solution[target];
			notes[target] = [];
			selectedIndex = target;
			renderSelection();
			updateStats();
			setStatus(statusEl, 'Hint used: square filled with the correct number.', '');
			checkWin();
		});

		undoBtn.addEventListener('click', function () {
			if (solved) {
				setStatus(statusEl, 'Cannot undo after solving.', '');
				return;
			}

			if (history.length === 0) {
				setStatus(statusEl, 'No moves to undo.', '');
				return;
			}

			const last = history.pop();
			board[last.index] = last.oldValue;
			notes[last.index] = last.oldNotes;
			selectedIndex = last.index;
			renderSelection();
			updateStats();
			setStatus(statusEl, 'Undid the last move.', '');
		});

		if (!game.hasAttribute('tabindex')) {
			game.setAttribute('tabindex', '0');
		}

		loadPuzzle();
	});
});
JS;

if (!function_exists('zo_game_sudoku_render')) {
	function zo_game_sudoku_render($post_id = 0, $module = array()) {
		$instance_id = 'zo-sudoku-' . ($post_id ? absint($post_id) : wp_rand(1000, 999999));

		ob_start();
		?>
		<div class="zo-game-root zo-game-root--sudoku" id="<?php echo esc_attr($instance_id); ?>" data-game="sudoku">
			<div class="zo-sudoku">
				<div class="zo-sudoku__hero">
					<div>
						<p class="zo-sudoku__eyebrow">Asker's Puzzle</p>
						<h3 class="zo-sudoku__title">Sudoku</h3>
						<p class="zo-sudoku__intro">
							Fill the 9x9 board so every row, every column, and every 3x3 box contains the numbers 1-9 exactly once.
						</p>
					</div>

					<div class="zo-sudoku__stats">
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Filled</span>
							<strong class="zo-sudoku__stat-value" data-role="filled">0 / 81</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Mistakes</span>
							<strong class="zo-sudoku__stat-value" data-role="mistakes">0</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Time</span>
							<strong class="zo-sudoku__stat-value" data-role="timer">00:00</strong>
						</div>
						<div class="zo-sudoku__stat">
							<span class="zo-sudoku__stat-label">Best Time</span>
							<strong class="zo-sudoku__stat-value" data-role="best-time">--:--</strong>
						</div>
					</div>
				</div>

				<div class="zo-sudoku__toolbar">
					<label class="zo-sudoku__difficulty-label">
						<span>Difficulty</span>
						<select class="zo-sudoku__difficulty" data-role="difficulty">
							<option value="easy">Easy</option>
							<option value="medium">Medium</option>
							<option value="hard">Hard</option>
						</select>
					</label>

					<div class="zo-sudoku__actions">
						<button type="button" class="zo-sudoku__button zo-sudoku__button--primary" data-action="new">New Puzzle</button>
						<button type="button" class="zo-sudoku__button" data-action="notes" aria-pressed="false">Notes: Off</button>
						<button type="button" class="zo-sudoku__button" data-action="reset">Reset</button>
						<button type="button" class="zo-sudoku__button" data-action="check">Check</button>
						<button type="button" class="zo-sudoku__button" data-action="hint">Hint</button>
						<button type="button" class="zo-sudoku__button" data-action="undo">Undo</button>
					</div>
				</div>

				<div class="zo-sudoku__layout">
					<div class="zo-sudoku__board-panel">
						<div class="zo-sudoku__board" data-role="board" aria-label="Sudoku board"></div>

						<div class="zo-sudoku__keypad" data-role="keypad" aria-label="Sudoku number pad">
							<button type="button" class="zo-sudoku__key" data-value="1">1</button>
							<button type="button" class="zo-sudoku__key" data-value="2">2</button>
							<button type="button" class="zo-sudoku__key" data-value="3">3</button>
							<button type="button" class="zo-sudoku__key" data-value="4">4</button>
							<button type="button" class="zo-sudoku__key" data-value="5">5</button>
							<button type="button" class="zo-sudoku__key" data-value="6">6</button>
							<button type="button" class="zo-sudoku__key" data-value="7">7</button>
							<button type="button" class="zo-sudoku__key" data-value="8">8</button>
							<button type="button" class="zo-sudoku__key" data-value="9">9</button>
							<button type="button" class="zo-sudoku__key zo-sudoku__key--wide" data-value="0">Erase</button>
						</div>
					</div>

					<div class="zo-sudoku__side">
						<div class="zo-sudoku__card">
							<h4 class="zo-sudoku__card-title">Rules</h4>
							<ul class="zo-sudoku__rules">
								<li>Each row must contain 1-9 once.</li>
								<li>Each column must contain 1-9 once.</li>
								<li>Each 3x3 box must contain 1-9 once.</li>
								<li>Blue numbers are fixed clues and cannot be changed.</li>
							</ul>
						</div>

						<div class="zo-sudoku__card">
							<h4 class="zo-sudoku__card-title">How To Play</h4>
							<p class="zo-sudoku__card-copy">
								Click a blank square, then type on your keyboard or use the number pad. Turn notes on to write small candidate numbers before choosing the final answer.
							</p>
						</div>

						<div class="zo-sudoku__status" data-role="status" aria-live="polite">
							Choose a square and start solving.
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}

return array(
	'slug'            => 'sudoku',
	'name'            => 'Sudoku',
	'author'          => 'Asker',
	'description'     => 'A classic 9x9 Sudoku puzzle with easy, medium, and hard boards.',
	'render_callback' => 'zo_game_sudoku_render',
	'inline_style'    => $css,
	'inline_script'   => $js,
);
