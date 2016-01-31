<?PHP
 $output = [];

 putenv("PYTHONPATH=/usr/lib/python2.7");
 putenv("LD_LIBRARY_PATH=/usr/local/lib");
 exec("python recognise.py at me.png 13000", $output);
 // the $output array now contains all lines printed by the python script 
?> 
<p> The similarity index is <?PHP echo $output[0]; ?> and the confidence level is <?PHP echo $output[1]; ?> . </p>
