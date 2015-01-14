class aw_php()
{
  include aw_apt

  package {
    [
      'php5-cli',
      'php5-mcrypt',
      'php5-intl',
      'php5-mysql',
      'php5-curl',
      'php5-xdebug'
    ]:
      ensure  => 'latest',
      require => Class['aw_apt']
  }
  
  package {
    [
      'apache2.2-common'
    ]:
      ensure  => 'purged',
      require => Package['php5-cli']
  }

  file { '/etc/php5/conf.d/90-locale.ini':
    ensure  => file,
    backup  => false,
    content => template('aw_php/locale.ini.erb'),
    require => Package['php5-cli']
  }

  file { '/etc/php5/conf.d/99-development.ini':
    ensure  => file,
    backup  => false,
    content => template('aw_php/development.ini.erb'),
    require => Package['php5-cli']
  }

  file { '/etc/php5/conf.d/99-xdebug.ini':
    ensure  => file,
    backup  => false,
    content => template('aw_php/xdebug.ini.erb'),
    require => Package['php5-xdebug']
  }

  file { '/usr/bin/php-debug':
    ensure  => file,
    backup  => false,
    content => template('aw_php/php-debug.erb'),
    mode    => 0777,
    require => Package['php5-xdebug']
  }

  file { '/etc/profile.d/php-debug-alias.sh':
    ensure  => file,
    backup  => false,
    content => template('aw_php/php-debug-alias.sh.erb'),
    mode    => 0644,
    require => Package['php5-xdebug']
  }
}
