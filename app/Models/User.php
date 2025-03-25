<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_kana',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // grade（親）とのリレーション
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
    // curriculum_progresses（子）とのリレーション
    public function curriculumProgresses(): HasMany
    {
        return $this->hasMany(CurriculumProgress::class, 'users_id');
    }
    // class_clear_checks（子）とのリレーション
    public function checks(): HasMany
    {
        return $this->hasMany(ClassesClearCheck::class, 'user_id');
    }

    public function updateProfile($data) {
        // \Log::info('UpdateProfile method called with data: ' . $data); // ログ追加
        \Log::info('UpdateProfile method called with data: ' . json_encode($data));

        $this->fill($data);

        if (isset($data['password'])) {
            $this->password = bcrypt($data['password']);
            // $this->password = $data['password'];
            \Log::info('Password updated in model'); // ログ追加
        } else {
            \Log::info('No password data received');
        }

        if (isset($data['profile_image'])) {
            // 一時ディレクトリから適切な場所に画像を移動
            $tempPath = $data['profile_image'];
            // ファイルの元の名前を取得
            $originalFileName = request()->file('profile_image')->getClientOriginalName();

            // ストレージに保存するパス
            $storagePath = 'images/profile/' . $originalFileName;

            // データベースに保存するパス
            $dbPath = 'storage/images/profile/' . $originalFileName;
    
            // ディレクトリが存在しない場合は作成
            if (!Storage::disk('public')->exists('images/profile')) {
                Storage::disk('public')->makeDirectory('images/profile');
            }
                
            if (Storage::disk('public')->exists($tempPath)) {
                Storage::disk('public')->move($tempPath, $storagePath);
            
                // 古いプロフィール画像を削除（存在する場合）
                if ($this->profile_image && $this->profile_image !== 'noimage.jpeg') {
                    Storage::disk('public')->delete(str_replace('storage/', '', $this->profile_image));
                }

                // profile_imageフィールドを新しいファイル名で更新
                $this->profile_image = $dbPath;
            }
        }
        // $this->save();
        // $this->fill($data);
        $result = $this->save();
        \Log::info('Save result: ' . ($result ? 'true' : 'false')); // ログ追加

    return $result;
    }
}
