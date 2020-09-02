def loadEnvironmentVariables(path){
    def props = readProperties  file: path
    keys= props.keySet()
    for(key in keys) {
        value = props["${key}"]
        env."${key}" = "${value}"
    }
} 

node {
    def app

    def registryUrl = ''        // these variables will set with values 
    def registryCredential = '' // project ./src/.env.jenkins file
    def tag = ''                //

    /*
    ./src/.env.jenkins file sample
    ------------------------------
    AWS_ACCOUNT_ID=999999999999
    AWS_REGION=us-east-1
    AWS_ECR_PATH=portal
    AWS_BEANSTALK_APP=BrandApp
    AWS_BEANSTALK_ENV_PREFIX=Brand      // for Brand-master-env and Brand-staging-env
    ------------------------------
    */

    stage('Clone repository') {
        checkout scm

        // read variables from .env.jenkins
        if ( fileExists('.env.jenkins') ) {
            loadEnvironmentVariables(".env.jenkins")
            tag = "${env.AWS_BEANSTALK_NAME}-${env.BRANCH_NAME}-${env.BUILD_NUMBER}"
            registryUrl = "https://${env.AWS_ACCOUNT_ID}.dkr.ecr.us-east-1.amazonaws.com"
            registryCredential = "ecr:${env.AWS_REGION}:${JENKINS_AWS_CREDENTIAL}"
            sh "echo Variables: tag=$tag  registryUrl=$registryUrl registryCredential=$registryCredential"
        } else {
            sh "echo .env.jenkins not found"
            return
        }
    }

    stage('Build web image') {
        def image = "web"
        def imageName = env.AWS_ECR_PATH + '/' + image
        dir ('docker/'+image) {
          app = docker.build(imageName + ":" + tag)
        }
        docker.withRegistry(registryUrl, registryCredential) {
          app.push(tag)
        }
        sh "docker rmi $imageName:$tag"
    }

    stage('Build nginx image') {
        def image = "nginx"
        def imageName = env.AWS_ECR_PATH + '/' + image
        dir ('docker/'+image) {
          app = docker.build(imageName + ":" + tag)
        }
        docker.withRegistry(registryUrl, registryCredential) {
          app.push(tag)
        }
        sh "docker rmi $imageName:$tag"
    }

    stage('Deploy to AWS Beanstalk') {
        def AWS_S3_BUCKET = "elasticbeanstalk-${env.AWS_REGION}-${env.AWS_ACCOUNT_ID}"
        def AWS_BEANSTALK_ENVIRONMENT = "${env.AWS_BEANSTALK_NAME}-${env.BRANCH_NAME}-env"

        if ( fileExists('src/index.html') ) {
            sh "sed -i 's/<TAG>/${env.BRANCH_NAME}-${env.BUILD_NUMBER}/' src/index.html"
        }

        if ( fileExists('src/index.php') ) {
            sh "sed -i 's/<TAG>/${env.BRANCH_NAME}-${env.BUILD_NUMBER}/' src/index.php"
        }

        if ( fileExists('Dockerrun.aws.json') ) {
            withCredentials([[$class: 'AmazonWebServicesCredentialsBinding',  credentialsId: JENKINS_AWS_CREDENTIAL, accessKeyVariable: 'AWS_ACCESS_KEY_ID', secretKeyVariable: 'AWS_SECRET_ACCESS_KEY']]) {
                sh "sed -i 's/<AWS_ACCOUNT_ID>/${AWS_ACCOUNT_ID}/' Dockerrun.aws.json"
                sh "sed -i 's/<AWS_ECR_PATH>/${AWS_ECR_PATH}/' Dockerrun.aws.json"
                sh "sed -i 's/<TAG>/$tag/' Dockerrun.aws.json"
                def zip = "jenkins-${AWS_BEANSTALK_ENVIRONMENT}-${BUILD_NUMBER}.zip"
                sh "zip -q -r ${zip} Dockerrun.aws.json .ebextensions/* ${volume}/*"
                sh "aws s3 cp ${zip} s3://${AWS_S3_BUCKET} --region ${AWS_REGION}"
                sh "aws elasticbeanstalk create-application-version --application-name ${AWS_BEANSTALK_APP} \
                    --version-label ${tag} --source-bundle S3Bucket='${AWS_S3_BUCKET}',S3Key='${zip}' --region ${AWS_REGION}"
                sh "aws elasticbeanstalk update-environment --application-name ${AWS_BEANSTALK_APP} \
                    --environment-name ${AWS_BEANSTALK_ENVIRONMENT} --version-label ${tag} --region ${AWS_REGION}"
            }
        } else {
            sh "echo Dockerrun.aws.json not found"
            return
        }
    }

    stage('Wait restart') {
        sh "sleep 40"
    }

    stage('Install jest and puppeteer') {
        sh "yarn install"
    }

    stage('Running functional tests') {
        sh "sed -i 's/<BRANCH_NAME>/${env.BRANCH_NAME}/' tests/*.test.js"
        sh "yarn run test"
    }
}