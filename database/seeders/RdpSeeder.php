<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Rdp;

class RdpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = '01/01/2017';
        $he1 = '08:00';
        $he2 = '12:00';
        $hs1 = '13:00';
        $hs2 = '17:00';
       // $ht = '08:00';
       // $ha = '00:00';
        //$hd = '00:00';
        
        $df = \DateTime::createFromFormat('d/m/Y', $data);
        $dataMysql = $df->format('Y-m-d');

        $rdp = new Rdp();
        $rdp->funcionario_id = 12;
        $rdp->data = $dataMysql;
        $rdp->entr1 = $he1;
        $rdp->entr2 = $he2;
        $rdp->sai1 = $hs1;
        $rdp->sai2 = $hs2;
//        $rdp->htrab = $ht;
//        $rdp->habon = $ha;
//        $rdp->hdeb = $hd;
        $rdp->save();
    }
}
