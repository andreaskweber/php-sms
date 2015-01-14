#
# site.pp
# Main entry point for puppet
#

node default
{
  class { 'aw_brand': }

  class { 'aw_packages': }

  class { 'aw_editor': }

  class { 'aw_timezone': }

  class { 'aw_ntp': }
  
  class { 'aw_php': }
  
  class { 'composer': }
}
