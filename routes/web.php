<?php

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/shariah', function(){
    $list = 'ALARABANK
EXIMBANK
FAREASTLIF
FIRSTSBANK
ISLAMIBANK
ISLAMIINS
ISLAMICFIN
PADMALIFE
PRIMELIFE
SHAHJABANK
SIBL
UNIONBANK
TAKAFULINS
AAMRANET
AAMRATECH
ACIFORMULA
ACMEPL
ADNTEL
ADVENT
AFCAGRO
AGNISYSL
AIL
ACFL
AMANFEED
AMBEEPHA
ANWARGALV
APEXSPINN
AOL
BANGAS
BDLAMPS
BPPL
BATASHOE
BBSCABLES
BDTHAI
BDCOM
BEACONPHAR
BENGALWTL
BERGERPBL
BXPHARMA
CENTRALPHL
COPPERTECH
DAFODILCOM
DOMINAGE
DOREENPWR
DSSL
ECABLES
EHL
EGEN
ESQUIRENIT
FAMILYTEX
FARCHEM
FEKDIL
FINEFOODS
FORTUNE
FUWANGFOOD
GENEXIL
GHCL
GHAIL
GP
HAKKANIPUL
HFL
HEIDELBCEM
HWAWELLTEX
IMAMBUTTON
INDEXAGRO
IBP
ITC
INTECH
INTRACO
JHRML
JMISMDL
KAY&QUE
KDSALTD
KBPPWBIL
KPCL
KPPL
KOHINOOR
LHBL
LINDEBD
LRBDL
MLDYEING
MALEKSPIN
MARICO
MATINSPINN
MIRACLEIND
MJLBD
MONNOCERA
MHSML
NAHEEACP
NFML
NAVANACNG
OIMEX
OAL
OLYMPIC
PDL
PRIMETEX
QUASEMIND
RAKCERAMIC
RDFOOD
RANFOUNDRY
RSRMSTEEL
RECKITTBEN
REGENTTEX
RINGSHINE
SSSTEEL
SAIHAMCOT
SAIHAMTEX
SALVOCHEM
SAMATALETH
SAMORITA
SPCL
SPCERAMICS
SHURWID
SILCOPHL
SILVAPHL
SIMTEX
SINGERBD
SINOBANGLA
SKTRIMS
SONALIPAPR
STANCERAM
SAPORTL
SUMITPOWER
DACCADYE
IBNSINA
TITASGAS
UPGDCL
USMANIAGL
VFSTDL
WALTONHIL
YPL
ZAHEENSPIN';
$listArray = explode(PHP_EOL, $list);
foreach($listArray as $code){
    $stock = Stock::where('code', $code)->first();
    $stock->cse_shariah = 1;
    $stock->save();
}
});


Route::get('/dse30', function(){
    $list = 'BATBC
BBSCABLES
BEACONPHAR
BEXIMCO
BRACBANK
BSCCL
BSRMLTD
BXPHARMA
CITYBANK
DELTALIFE
EBL
FORTUNE
GP
GPHISPAT
IDLC
ISLAMIBANK
LANKABAFIN
LHBL
MPETROLEUM
OLYMPIC
ORIONPHARM
POWERGRID
PUBALIBANK
RENATA
ROBI
SINGERBD
SQURPHARMA
SUMITPOWER
TITASGAS
UPGDCL';
    $listArray = explode(PHP_EOL, $list);
    // dd($listArray);
    foreach ($listArray as $code) {
        $stock = Stock::where('code', $code)->first();
        $stock->dse_30 = 1;
        $stock->save();
    }
});

Route::get('/cse30', function(){
    $list = 'GREENDELT
MATINSPINN
SQURPHARMA
ACMELAB
OLYMPIC
CONFIDCEM
PREMIERCEM
BSRMSTEEL
BSRMLTD
EHL
PADMAOIL
SUMITPOWER
POWERGRID
JAMUNAOIL
MPETROLEUM
TITASGAS
MJLBD
LINDEBD
DOREENPWR
BPPL
CITYBANK
PUBALIBANK
PRIMEBANK
DHAKABANK
BANKASIA
UTTARABANK
EBL
JAMUNABANK
PREMIERBAN
IDLC';
    $listArray = explode(PHP_EOL, $list);
    // dd($listArray);
    foreach ($listArray as $code) {
        $stock = Stock::where('code', $code)->first();
        $stock->cse_30 = 1;
        $stock->save();
    }
});


Route::post('/stock', function(Request $request){
    $data = array_map('str_getcsv', file($request->file('stocks')));
    $newArray = array_map(function ($values) {
        $arr = explode(' (',$values[0]);
        Stock::create([
            'code' => $arr[0],
            'company' => str_replace(')', '', $arr[1])
        ]);
    }, $data);
    
});
