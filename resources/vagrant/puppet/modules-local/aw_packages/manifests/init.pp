class aw_packages()
{
  package { ['wget', 'htop', 'curl', 'ant', 'git']:
    ensure => 'latest'
  }
}
