@servers(['local' => '127.0.0.1', 'prod' => 'ubuntu@stanlix.com'])

@task('clean', ['on' => 'local'])
    if [ -f sam.zip ]; then
        rm sam.zip; 
    fi
@endtask

@task('zip', ['on' => ['local']])
    zip -r sam.zip ./ -x '*vendor*' -x 'node_modules*' -x '*.git*' -x 'storage*' -x '.idea*' -x '.*' -x 'test*' -x 'webpack*' -x 'yarn*' -x '*phpunit*' -x 'package*' -x 'Envoy*' -x 'zi*'
@endtask

@task('upload', ['on' => 'local'])
    scp sam.zip ubuntu@stanlix.com:/home/ubuntu/deployments/sam/;
@endtask

@task('unzip', ['on' => ['prod']])
    cd /home/ubuntu/deployments/sam;
    unzip -o sam.zip -d ./active
@endtask

@task('set-permissions', ['on' => ['prod']])
    cd /home/ubuntu/deployments/sam/active;
    sudo chmod 777 -R ./storage/;
@endtask

@story('deploy', ['confirm' => false])
    clean
    zip
    upload
    unzip
    set-permissions
    clean
@endstory