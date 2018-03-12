<?php
 
class FileType extends CI_Controller {
     public $classtree = FALSE;
     public function __construct() {
        parent::__construct();	
       
    
        }
 
        public function index(){
			
               // $view = $this->load->view('fileTypeView');
			 
 				$this->load->model("m_checkSession","S");
				$up_user=$this->S->check();
                $db = $this->db;
                $this -> classArray =$this->db->query("select * from userFileType where userId='".$up_user."' or stem=1  order by id asc")->result_array(false);
				//= $db -> select("*") -> from('userfiletype') ->where('userId','2') -> orderby('id','asc') -> orderby('fatherId','asc') -> get() -> result_array(FALSE);
				
				$rst=$this -> classArray;
                if ( count( $rst ) > 0 )
				{
                        $topItm = array();
                        foreach ($rst  as  $k=>$rs )
						{
                                //$tmpTree[][] = $tmpclass;
								if($rs['fatherId']==0)
								{
									$topItm[$rs["id"]]=$rs;
									unset($rst[$k]);
								}

                        }
						$ctree=array();
						$m=$this->_listclass($topItm,$rst);
						//print_r($m);
						
						$data["TreeSouce"]=$m;
						$this->load->view('resourceManage/fileTypeView',$data);
                }
        }
 
        public function _listclass($topItm,$rst,$o=1)
		{
			$i=0;
			$ctree=array();
			foreach($topItm as $k=>$v)
			{
				if($o)
				{
					$ctree[$k]=$v;
				}
				foreach($rst as $key=>$rs)
				{
					if($rs["fatherId"]==$v["id"])
					{
						$i=1;
						$N_RS[0]=$rs;
						unset($rst[$key]);
						
						if($o)
						{
							$ctree[$k]["childNodes"][$key]=$N_RS[0];
							$ctree[$k]["childNodes"][$key]["childNodes"]=$this->_listclass($N_RS,$rst,0);
						}
						else
						{
							$ctree[$key]=$N_RS[0];
							$ctree[$key]["childNodes"]=$this->_listclass($N_RS,$rst,0);
						}
					}
					
				}
			}
			return $ctree;
			/*if($i)
			{
				
			}
			else
			{
				return NULL;
			}*/
			
        }

       
       
}