set :application, "gyman"
set :domain,      "uirapu.ru"
set :deploy_to,   "/var/www/gyman.pl"
set :app_path,    "app"

set :user, "uirapuru"

set :ssh_options, {
    :forward_agent => true,
    :auth_methods => ["publickey"],
}

set :use_composer, true
set :composer_options,  "--no-dev --verbose --prefer-dist --optimize-autoloader"
set :update_vendors, false
set :vendors_mode, "install"

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor", app_path + "/spool"]

set :php_bin, "php"

set :repository,  "https://github.com/uirapuru/gyman.pl.git"
set :scm,         :git

set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

set :use_sudo,  false

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL