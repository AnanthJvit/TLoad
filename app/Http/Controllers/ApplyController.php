<?php
namespace App\Http\Controllers;
use Input;
use Validator;
use Redirect;
use Request;
use Session;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class ApplyController extends Controller
{
    public function upload()
    {
        try {
            $s3 = S3Client::factory(array(
                'credentials' => array('key' => env('KEY'), 'secret' => env('SECRET')),
                'region' => env('REGION'),
                'version' => env('VERSION'),
                'scheme' => env('SCHEME')));
            
            $Fl              = Input::file('file');
            $name            = $Fl->getClientOriginalName();
            $destinationPath = 'uploads'; // upload path
            $extension       = $Fl->getClientOriginalExtension(); // getting file extension
            $fileName        = rand(15000, 99999) . '.' . $extension; // renameing file
            $Fl->move($destinationPath, $fileName); // uploading file to given path
            $pathtofile     = "uploads/{$fileName}";
            $s3->path_style = true;
            $s3->putObject(array(
                'Bucket' => env('BUCKET'),
                'Key' => "uploads/{$name}",
                'Body' => fopen($pathtofile, 'rb'),
                'ACL' => 'public-read'
            ));
            Session::flash('success', 'Upload successfully');
            return Redirect::to('upload');
        }
        catch (S3Exception $e) {
            die("There was an ( Error :" . $e->getMessage() . " ) in uploading file");
        }
    }
}
?>