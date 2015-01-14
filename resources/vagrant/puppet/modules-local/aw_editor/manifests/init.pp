class aw_editor($package = 'nano')
{
  package { "${package}":
    ensure => 'latest',
  }

  exec { "update-alternatives --set editor /bin/${package}":
    path    => '/usr/bin:/usr/sbin',
    unless  => "test /etc/alternatives/editor -ef /bin/${package}",
    require => Package["${package}"],
  }
}
