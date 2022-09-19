<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Pictuer;

use App\Models\User;
use Auth ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AlbumsRequest;
class AlbumPictuerController extends Controller
{
    public function store(AlbumsRequest $req)
    {
        $album_rolse   = [
            'name' =>  $req->get('album'),
            'user_id'=> Auth::id()
        ];
      $name_photos = $req->get('name_photos');
        try{
            DB::beginTransaction();

              $album  =  Album::create( $album_rolse );

              $newFolder = str_replace(' ', '_',$album->name);
              $thisAlbum = str_replace(' ','_',Auth::user()->name ) ;
              $directory = "albums/{$thisAlbum}/{$newFolder}" ;
              $Pictuer_insert =[];

            foreach($req->file('file') as $key => $filse)
            {
              $url =  Storage::disk('public')->putFile($directory  ,$filse);
              array_push($Pictuer_insert  ,
              [
                 'name' => $name_photos[$key ] ,
                 'url' => $url ,
                 'album_id' => $album->id ,
                 'created_at' =>  date('Y-m-d H:i:s'),
                 'updated_at' => date('Y-m-d H:i:s')
              ]);
            }
         
            Pictuer::insert($Pictuer_insert);
            DB::commit();

            return response()->json(['success'=> true  , 'data' => $album,'type' => "POST" , 'status' => 200]);
        }catch(\Exception $ex){
            DB::rollback();
            // get all old file store  directory   with  array push all path and delete throw  Exception
            return response()->json(['success'=> false ,'type' => "POST" , 'status' => 400]);
        }

    }

public function albums()
{
    $user = Auth::id() ;

    $list = Album::where('user_id' ,  $user)->pluck('name' ,'id');
    $list->prepend( "انقل الي.." ,  0);
   
    $ablumsUser  = User::with('albums' , 'albums.pictuers')->findOrFail( $user) ;

  

    return view('albums', compact('ablumsUser' , 'list'));
}

public function moveAlbum(Request $req,  $id)
{

    $find = [$id , $req->to_album] ;
    $album =  Album::with('pictuers' ,'user')->whereIn('id', $find)->get();

    $from_album = $album->find($find[0]);

     if($from_album->pictuers->count() === 0) return redirect()->back() ;
 
    $to_album = $album->find($find[1]);

    $userFoder = str_replace(' ', '_',$to_album->user->name);
    $oldFolder = str_replace(' ', '_',$to_album->name);
    $directory  = "albums/{$userFoder}/";
    $findFolder = $directory . $oldFolder ;
    $directories=   Storage::disk('public')->allDirectories($directory);
    $destination =  $directories[array_search($findFolder,$directories)] ;

    foreach($from_album->pictuers as $move)
    {
         $source = $move->url ;
         $fieName = substr( $source ,strrpos( $source, '/'));
         Storage::disk('public')->move($source , $destination . $fieName);
         $fieName = substr( $source ,strrpos( $source, '/')); 
         $move->url =  $destination  . $fieName  ;
         $move->album_id =  $to_album->id ;
         $move->save();
    }

    return redirect()->back();

}
public function gallery($id)
{
    $album =  Album::with('pictuers' ,'user')->findOrFail($id);
    return view('gallery' ,compact('album'));
}

public function updateGalleryAjax(Request $req,  $id)
{
   $pictuer = Pictuer::findOrFail($id);
   $data_update = [];
   if($req->has('file'))
   {
    if(Storage::disk('public')->exists($pictuer->url))
    {
        Storage::disk('public')->delete($pictuer->url);
    }
    $directory  = substr( $pictuer->url , 0 , strrpos( $pictuer->url, '/'));
    $newFilename =  Storage::disk('public')->putFile($directory  ,$req->file);
    $data_update += ['url' => $newFilename] ;
   }

   if(! empty($req->name))
   {
    $data_update += ['name' => $req->name] ;
   }
   $pictuer->update($data_update);
   $data = [
        'id' => $pictuer->id ,
        'name' => $pictuer->name,
         'url' => asset(Storage::url($pictuer->url))
   ];
  
   return response()->json(['success'=>$data   ,'type' => "PUT" , 'status' => 200]);
}


public function deletePictuer($id)
{
    $pictuer = Pictuer::findOrFail($id);
    if(Storage::disk('public')->exists($pictuer->url))
    {
        Storage::disk('public')->delete($pictuer->url);
    }
    $pictuer->delete();

    return redirect()->back();
}

public function deleteAlbum($id)
{
    
    $Album = Album::with('user')->findOrFail($id);
    $userFoder = str_replace(' ', '_',$Album->user->name);
    $oldFolder = str_replace(' ', '_',$Album->name);
    $directory  = "albums/{$userFoder}/";
    $directory = $directory . $oldFolder;

    if( Storage::disk('public')->exists($directory))
    {
        Storage::disk('public')->deleteDirectory($directory);
    }

    $Album->delete();

    return redirect()->back();
}

}



