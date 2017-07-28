<?php
namespace core;

session_start();

class User
{
  public function getAttribute($attr)
  {
    return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
  }

    public function getFlash()
  {
      ?>
      <div style="text-align: center;" class="alert alert-<?=($_SESSION['flash']['type']); ?>">
          <?=$flash =($_SESSION['flash']['value']);?>
      </div>
      <?php

    unset($_SESSION['flash']);

    return $flash;
  }



  public function hasFlash()
  {
    return isset($_SESSION['flash']);
  }

  public function isAuthenticated()
  {
    return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
  }

  public function setAttribute($attr, $value)
  {
    $_SESSION[$attr] = $value;
  }

  public function setAuthenticated($authenticated = true)
  {
    if (!is_bool($authenticated))
    {
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
    }

    $_SESSION['auth'] = $authenticated;
  }

  public function setFlash($value,$type='danger')
  {
    $_SESSION['flash'] =[
        'value'=>$value,
        'type'=>$type
    ] ;
  }

    public function disconect()
    {
        $_SESSION['auth'] = false;
    }

}