set :application, "gyman"
set :domain,      "#{application}.pl"
set :deploy_to,   "/home/uirapuru/domains/gyman.pl"
set :app_path,    "app"

set :ssh_options, {
    :forward_agent => true,
    :auth_methods => ["publickey"],
    :port => 59184
}

set :use_composer, true
set :composer_options,  "--no-dev --verbose --prefer-dist --optimize-autoloader"
set :update_vendors, true

set :shared_files,      ["app/config/parameters.yml"]
set :php_bin,           "/usr/local/php5.4/bin/php"

set :repository,  "https://github.com/uirapuru/gyman.pl.git"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

set :use_sudo,  false

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL