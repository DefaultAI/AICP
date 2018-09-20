<?php

/*  #####################
    #                   #
    #     Pac Class     #
    #                   #
    #####################
*/

class PacClass{

/*  ###############################################################
    ######################                   ######################
    ######################     STATIC        ######################
    ######################                   ######################
    ###############################################################
*/

    // extras will not be copied. the creator shall create its own extras
    public static function copy($pac,$new_extras=array()){
        $user=0;
        $src=0;
        $trg=0;
        $ddata=0;
        $extras=$new_extras;
        //check if the input is a PacClass
        if(is_a($pac,'PacClass')){
            $pac_array=$pac->get_array();
            $user=$pac_array['user'];
            $src=$pac_array['src'];
            $trg=$pac_array['trg'];
            $raws=$pac_array['raws'];
            $ddata=$pac_array['ddata'];
        }
        $new_pac=new PacClass($user,$src,$trg,$raws,$ddata,$extras);
        return $new_pac;
    }

    // make a full copy by copying extras
    public static function full_copy($pac){
        $pac_array=$pac->get_array();
        return self::copy($pac,$pac_array['extras']);
    }

    public static function new_empty($extras=array()){
        return new PacClass(0,0,0,0,0,$extras);
    }

    // the input is a json encoded string from external ai 
    // here we make an array and create a pac out of it
    // we need to check if its set all correct 
    // to not ruin the code because of losy external ai with bad respond
    public static function new_by_ahoy($ahoy){
        $respond=json_decode($ahoy,TRUE);
        $user=isset($respond['user'])?$respond['user']:0;
        $src=isset($respond['src'])?$respond['src']:0;
        $trg=isset($respond['trg'])?$respond['trg']:0;
        $raws=isset($respond['raws'])?$respond['raws']:0;
        $ddata=isset($respond['ddata'])?$respond['ddata']:0;
        $extras=isset($respond['extras'])?$respond['extras']:array();
        return new PacClass($user,$src,$trg,$raws,$ddata,$extras);
    }

/*  ###############################################################
    ######################                   ######################
    ######################     PUBLIC        ######################
    ######################                   ######################
    ###############################################################
*/

    function __construct($user,$src,$trg,$raws,$ddata,$extras=array()) {
        // $args = array(user,src,trg,raws,ddata)
        $this->user=$user;
        $this->src=$src;
        $this->trg=$trg;
        $this->raws=$raws;
        $this->ddata=$ddata;
        $this->extras=$extras;
        $this->meta=$this->get_meta();
    }

    public function get_array(){
        return array('user'=>$this->user,'src'=>$this->src,'trg'=>$this->trg,'raws'=>$this->raws,'ddata'=>$this->ddata,'extras'=>$this->extras,'meta'=>$this->meta);
    }

/*  ###############################################################
    ######################                   ######################
    ######################     PRIVATE       ######################
    ######################                   ######################
    ###############################################################
*/

    private $user;
    private $src;
    private $trg;
    private $raws;
    private $ddata;
    private $extras;    // array() customised by pac creators. may include key codes, version, etc.
    private $meta;      // array() includes info added by the pac class like timestamp and control stuff

    private function get_meta(){
        return array('version'=>'v2-1','timestamp'=>time());
    }
}
