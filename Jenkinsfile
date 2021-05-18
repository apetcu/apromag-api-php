def branchName = env.BRANCH_NAME;
def uploadCredentialsId = 'aprozi-ftp';
def uploadFile = 'api';

node {
    try {
        if (branchName == 'master') {
            stage ('Cleanup workspace') {
                cleanWs();
            }

            stage('Checkout') {
                checkout([$class: 'GitSCM', branches: [[name: branchName]], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[credentialsId: '22790bc7-f861-4ed2-9ca3-6fbe884904b6', url: 'https://sovezea.go.ro/gitea/apromag/apromag-api-php.git']]]);
                commitMessage = sh(returnStdout: true, script: 'git show -s --format=format:"*%s* by %an" HEAD').trim();
            }

            stage('Check php version') {
                sh "php -v"
            }

            stage('Get composer') {
                sh "curl -sS https://getcomposer.org/installer | php"
                sh "php composer.phar install"
                sh "cp .env.prod .env"
            }

            stage('Check directory') {
                sh "ls -laG"
            }

            stage('Zip everything') {
             zip glob: 'storage/**, app/**, bootstrap/**, config/**, resources/**, routes/**, storage/**, vendor/**, .env', zipFile: uploadFile + ".zip"
            }

            stage('Upload to ftp') {
                ftpPublisher alwaysPublishFromMaster: true, continueOnError: false, failOnError: false, publishers: [
                    [configName: uploadCredentialsId, transfers: [
                        [asciiMode: false,
                        sourceFiles: uploadFile + ".zip",
                        cleanRemote: false,
                        excludes: '',
                        execTimeout: 120000,
                        flatten: false,
                        makeEmptyDirs: false,
                        noDefaultExcludes: false,
                        patternSeparator: '[, ]+',
                        remoteDirectory: "/deployer",
                        remoteDirectorySDF: false,
                        ]
                    ], usePromotionTimestamp: false, useWorkspaceInPromotion: false, verbose: true]
                ]
            }

            stage('START deployer') {
              sh "curl -sS https://deployer.aprozi.ro/"
            }

        } else {
            stage('Skip build for branch ' + branchName) {
                echo 'Branch is not master. Skipping..  .'
            }
        }
    } catch (e) {
        print e;
    }
}
