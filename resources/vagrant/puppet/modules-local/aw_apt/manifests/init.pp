class aw_apt()
{
  class { 'apt':
    always_apt_update => true
  }

  apt::key { 'dotdeb-key':
    key        => '89DF5277',
    key_source => 'http://www.dotdeb.org/dotdeb.gpg',
  }

  apt::source { 'dotdeb-php':
    location          => 'http://packages.dotdeb.org',
    repos             => 'all',
    include_src       => true,
    require           => Apt::Key['dotdeb-key']
  }
}
