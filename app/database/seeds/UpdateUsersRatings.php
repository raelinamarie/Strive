<?php

class UpdateUsersRatings extends Seeder {

    public function run() {
        $ratings = DB::select("SELECT rating_for,SUM(rating)/COUNT(*) as 'average',COUNT(*) as 'total_ratings' FROM ratings GROUP BY rating_for");
        foreach($ratings as $row){
            $user = User::find($row->rating_for);
            $user->total_ratings = $row->total_ratings;
            $user->avg_rating = $row->average;
            $user->save();
        }
    }
}