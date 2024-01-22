<?php
namespace App\Http\Traits;

use App\Models\User;
use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait LikeableTrait
{

    public function toggleLike(User $user,String $reaction)
    {
        if ($this->isLikedByUser($user,$reaction)) {

            $this->remove($user);
            $message = get_class($this) .' '. $reaction .'removed successfully';
        } else {
            if ($reaction == "like"){
                if ($this->isLikedByUser($user,"dislike")) {

                    $this->remove($user);
                    $message = get_class($this) .' dislike removed successfully';
                }
                $this->add($user,$reaction);

            }else if ($reaction == "dislike"){
                if ($this->isLikedByUser($user,"like")) {
                    $this->remove($user);
                    $message = get_class($this) .' like removed successfully';
                }
                $this->add($user,$reaction);

            }
            $message = get_class($this) .' '. $reaction .' successfully';
        }

        return response()->json(['message' => $message]);
    }

    public function isLikedByUser(User $user,string $reaction): bool
    {
        return $this->likes()->where('user_id', $user->id)->where('reaction',$reaction)->exists();
    }

    private function add(User $user,string $reaction)
    {
        $user->likes()->create([
            'likable_id' => $this->id,
            'likable_type' => get_class($this),
            'reaction' => $reaction,
        ]);
    }

    private function remove(User $user)
    {
        $this->likes()->where([
            'user_id' => $user->id,
            'likable_id' => $this->id,
            'likable_type' => get_class($this),
        ])->delete();
    }

    public function likesCount($reaction): int
    {
        return $this->likes()->where('reaction',$reaction)->count();
    }
}
