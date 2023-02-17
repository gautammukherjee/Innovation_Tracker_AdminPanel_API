pipeline {
    agent any

    stages {
        stage('deploy to laravel') {
            steps {
                sshPublisher(publishers: [sshPublisherDesc(configName: 'angular-v1', transfers: [sshTransfer(cleanRemote: false, excludes: '', execCommand: '', execTimeout: 120000, flatten: false, makeEmptyDirs: false, noDefaultExcludes: false, patternSeparator: '[, ]+', remoteDirectory: '/var/www/html/backend_extra/', remoteDirectorySDF: false, removePrefix: '', sourceFiles: '**/*')], usePromotionTimestamp: false, useWorkspaceInPromotion: false, verbose: false)])
            }
        }
    }
}


// pipeline {
//     agent any

//     stages {
//         stage('deploy') {
//             steps {
//                 sshPublisher(publishers: [sshPublisherDesc(configName: 'server-demo', transfers: [sshTransfer(cleanRemote: false, excludes: '', execCommand: '', execTimeout: 120000, flatten: false, makeEmptyDirs: false, noDefaultExcludes: false, patternSeparator: '[, ]+', remoteDirectory: '/var/www/html/backend2/', remoteDirectorySDF: false, removePrefix: '', sourceFiles: '**/*')], usePromotionTimestamp: false, useWorkspaceInPromotion: false, verbose: false)])
//             }
//         }
//     }
// }
// comeent this file
//piyush
//again
//today 15/01/2023


// pipeline{
//     agent any
//     environment{
//         staging_server="3.109.155.241"
//     }
//     stages{
//         stage('Deploy to Remote'){
//             // agent {label 'slave_api'}
//             steps{
//                 // sh '''
//                 //     for fileName in `find ${WORKSPACE} -type f -mmin -10 | grep -v ".git" | grep -v "Jenkinsfile"`
//                 //     do
//                 //         fil=$(echo ${fileName} | sed 's/'"${JOB_NAME}"'/ /' | awk {'print $2'})
//                 //         scp -r ${WORKSPACE}${fil} root@${staging_server}:/var/www/html/backend_api${fil}
//                 //     done
//                 // '''
//                 sh 'scp -r ${WORKSPACE}/* root@${staging_server}:/var/www/html/backend2/'
//             }
//         }
//     }
// }
