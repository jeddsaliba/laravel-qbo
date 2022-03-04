<?php

namespace Pns\LaravelQbo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QboConfig extends Model
{
  use HasFactory;

  protected $table = 'qbo_config';

  protected $fillable = [
    'auth_code',
    'realm_id',
    'access_token',
    'refresh_token',
    'x_refresh_token_expires_in',
    'expires_in'
  ];
  
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'auth_code' => 'string',
    'realm_id' => 'string',
    'access_token' => 'string',
    'refresh_token' => 'string',
    'x_refresh_token_expires_in' => 'datetime',
    'expires_in' => 'datetime'
  ];

  // Disable Laravel's mass assignment protection
  protected $guarded = [];

  public function store($request, $accessToken) {
    $saveQboConfig = QboConfig::find(1);
    if ($saveQboConfig) {
        if ($request->code) {
            $saveQboConfig->auth_code = $request->code;
        }
        if ($request->realmId) {
            $saveQboConfig->realm_id = $request->realmId;
        }
        if ($accessToken['access_token']) {
            $saveQboConfig->access_token = $accessToken['access_token'];
        }
        if ($accessToken['refresh_token']) {
            $saveQboConfig->refresh_token = $accessToken['refresh_token'];
        }
        if ($accessToken['x_refresh_token_expires_in']) {
            $saveQboConfig->x_refresh_token_expires_in = $accessToken['x_refresh_token_expires_in'];
        }
        if ($accessToken['expires_in']) {
            $saveQboConfig->expires_in = $accessToken['expires_in'];
        }
        $saveQboConfig->save();
    } else {
        $saveQboConfig = QboConfig::updateOrCreate(['id' => 1], [
            'auth_code' => $request->code,
            'realm_id' => $request->realmId,
            'access_token' => $accessToken['access_token'],
            'refresh_token' => $accessToken['refresh_token'],
            'x_refresh_token_expires_in' => $accessToken['x_refresh_token_expires_in'],
            'expires_in' => $accessToken['expires_in']
        ]);
    }
    return $saveQboConfig;
  }
}