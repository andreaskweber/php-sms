class aw_brand (
  $templateMotd = 'aw_brand/motd.erb',
  $templateProfile = 'aw_brand/profile.erb'
) {
  if $::kernel == 'Linux' {
    file { '/etc/motd':
      ensure  => file,
      backup  => false,
      content => template($templateMotd),
    }
  }

  if $::kernel == 'Linux' {
    file { '/etc/profile':
      ensure  => file,
      backup  => false,
      content => template($templateProfile),
    }
  }
}
