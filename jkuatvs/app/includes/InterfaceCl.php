<?PHP
//create an inerface between the face recognition module and the  
class InterfaceCl {
	
   	
   public function setEnv()
	{
	 putenv("PYTHONPATH=/usr/lib/python2.7");
 	 putenv("LD_LIBRARY_PATH=/usr/local/lib");
	} 
    public function updateEigenModel()
	{
	 //sets the required paths
	 $this->setEnv();
	 //python module to create the eigenface model
	 exec("python /opt/lampp/htdocs/jkuatvs/eigensave.py /opt/lampp/htdocs/jkuatvs/photos");
	}
    public function faceAuthenticate($facephoto)
	{
	 $output = [];
	 //set the required paths
	 $this->setEnv();
	 //calls the python module to compare faces
	 exec("sudo python /opt/lampp/htdocs/jkuatvs/recognise.py /opt/lampp/htdocs/jkuatvs/photos /opt/lampp/htdocs/jkuatvs/".$facephoto." 1300000", $output);
	 return $output;
	}  
} 
?> 
