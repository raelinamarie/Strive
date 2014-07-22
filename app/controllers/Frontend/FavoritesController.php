<?php  namespace Controllers\Frontend;

use Auth;
use Authority\Exceptions\ValidationException;
use DB;
use Input;
use Redirect;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use User;
use Validator;

class FavoritesController extends BaseController {
    public function __construct() {
    }

    public function userFavoritesSwitch($user_id, $job_id) {
        if (Auth::user()->id != $user_id) {
            throw new UnauthorizedHttpException('Unauthorized');
        }
        $validator = Validator::make(['job_id' => $job_id], ['job_id' => 'required|integer|exists:jobs,id|']);
        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }
        $favorites = DB::table('user_favorites_jobs')->where('job_id', '=', $job_id)->where('user_id', '=', $user_id)->first();
        if ($favorites != NULL) {
            $delete = $this->userFavoritesDelete($user_id,$job_id);
            $message = ($delete == true) ? 'Job removed from Favorites' : 'Something went wrong. Job not removed from Favorites';
            return Redirect::back()->with('message', $message);
        }
        else{
            $message = ($this->userFavoritesAdd($user_id,$job_id) != null) ? 'Job Added to Favorites' : 'Something went wrong. Job not added to Favorites';
            return Redirect::back()->with('message',$message);
        }
    }

    public function userFavoritesDelete($user_id,$job_id){
        if (Auth::user()->id != $user_id) {
            throw new UnauthorizedHttpException('Unauthorized');
        }
        $return = DB::delete('delete from user_favorites_jobs where user_id = ? and job_id = ?',array($user_id,$job_id));
        if($return){
            return true;
        }
        else{
            return false;
        }
    }

    public function userFavoritesAdd($user_id,$job_id){
        if (Auth::user()->id != $user_id) {
            throw new UnauthorizedHttpException('Unauthorized');
        }
        /** @var \User $user */
        $user = User::find($user_id);
        $user->favorites()->attach($job_id);
        if($user->save()){
            return true;
        }
        else{
            return false;
        }
    }
}