<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'CompanyId',
        'AccountId',
        'Name',
        'IsDone',
    ];

    protected $dates = ['Deadline', 'created_at', 'updated_at'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'AccountId', 'CompanyId');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

	public function sentAccounts(): BelongsToMany
	{
		return $this->belongsToMany(Account::class, 'task_has_accounts', 'TaskId', 'AccountId');
	}

	public function files(): HasMany
	{
		return $this->hasMany(File::class, 'id');
	}
}
