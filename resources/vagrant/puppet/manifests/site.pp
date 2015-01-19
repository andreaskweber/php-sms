#
# site.pp
# Main entry point for puppet
#

node default
{
  class { 'aw_branding': }

  class { 'aw_packages': }

  class { 'aw_editor': }

  class { 'aw_time': }

  class { 'aw_php':
    development   => true,
    remove_apache => true
  }

  class { 'composer': }
}
