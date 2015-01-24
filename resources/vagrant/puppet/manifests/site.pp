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

  class { 'aw_apt_dotdeb': }

  class { 'aw_php':
    development   => true,
    remove_apache => true
  }

  class { 'aw_composer': }

  #aw_composer::token { 'vagrant':
  #  home_dir => '/home/vagrant',
  #  token    => 'enter_your_github_oauth_token_here'
  #}
}
