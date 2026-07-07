deployment_path="/home/betanz6/shopping_betanzos.org/test/"
php_path="/usr/bin/php"
composer_path="/opt/cpanel/composer/bin/composer"

echo "`date`- STARTING Deployment No $BUILD_NUMBER" >>${deployment_path}log.txt
cd ${deployment_path}

tar xjf ${deployment_path}${JOB_NAME}.tar.bz2
echo "`date`- Extracting ${JOB_NAME}.tar.bz2" >>${deployment_path}log.txt

mv "$JOB_NAME" "deploy_$BUILD_NUMBER"
echo "`date`- Moving $JOB_NAME to deploy_$BUILD_NUMBER" >>${deployment_path}log.txt

mv "deploy_$BUILD_NUMBER" ${deployment_path}
echo "`date`- Move deploy_$BUILD_NUMBER to ${deployment_path}" >>${deployment_path}log.txt

#Removing tar.bz2 file
rm -f ${deployment_path}${JOB_NAME}.tar.bz2
echo "`date`- Delete qa-s.tgz" >>${deployment_path}log.txt

#Coping .env file from current
cp ${deployment_path}current/.env "${deployment_path}deploy_$BUILD_NUMBER/.env"
echo "`date`- Coping .env file from current" >>${deployment_path}log.txt

#Copying database.sqlite file from current
cp ${deployment_path}database/database.sqlite "${deployment_path}deploy_$BUILD_NUMBER/database/database.sqlite"
echo "`date` - Copied database.sqlite to build $BUILD_NUMBER." >>${deployment_path}log.txt

#Copying storage directory file from current deployment
cp -r ${deployment_path}current/storage "${deployment_path}deploy_$BUILD_NUMBER/"
echo "`date` - Copied storage directory from current deployment to build $BUILD_NUMBER." >>${deployment_path}log.txt

#Copying .htaccess if exists
if [ -f "${deployment_path}current/public/.htaccess" ]; then
    echo "${deployment_path}current/public/.htaccess exists copying to: deploy_$BUILD_NUMBER"
    cp ${deployment_path}current/public/.htaccess "${deployment_path}deploy_$BUILD_NUMBER/public/.htaccess"
fi

#Copying php.ini if exists
if [ -f "${deployment_path}current/public/php.ini" ]; then
    echo "${deployment_path}current/public/php.ini exists copying to: deploy_$BUILD_NUMBER"
    cp ${deployment_path}current/public/php.ini "${deployment_path}deploy_$BUILD_NUMBER/public/php.ini"
fi

#Copying composer.json file from current
cp ${deployment_path}current/composer.json "${deployment_path}deploy_$BUILD_NUMBER/composer.json"
echo "`date`- Copying composer.json file from current" >>${deployment_path}log.txt

#Checking if composer.lock exists
if [ -f "${deployment_path}deploy_$BUILD_NUMBER/composer.lock" ]; then
    echo "${deployment_path}deploy_$BUILD_NUMBER/composer.lock exists"
    rm "${deployment_path}deploy_$BUILD_NUMBER/composer.lock"
fi




#Removing the link
rm ${deployment_path}current
echo "`date`- Removing current link" >>${deployment_path}log.txt

#Re-creating the link to the new name
ln -s "${deployment_path}deploy_$BUILD_NUMBER" ${deployment_path}current
echo "`date`- Re-creating current link to point to: ${deployment_path}deploy_$BUILD_NUMBER" >>${deployment_path}log.txt

cd ${deployment_path}current
#Put the site into maintenace mode
${php_path} artisan down
echo "`date`- Put the application into maintenance mode" >>${deployment_path}log.txt

#Running composer install
echo "`date`- About to run composer install" >>${deployment_path}log.txt
composer install

#Run migration
#echo "`date`- Running seed if it's not production" >>${deployment_path}log.txt
#if [ `grep -i "APP_ENV=production" ${deployment_path}current/.env | wc -l` -le 0 ]; then
#        echo "`date`- Running seed" >>${deployment_path}log.txt
#        ${php_path} artisan migrate:refresh --seed
#else
#        echo "`date`- Running StoreProccedureSeeder" >>${deployment_path}log.txt
#        ${php_path} artisan db:seed --force --class=StoreProccedureSeeder
#fi

#Creating link
echo "`date`- Creating storage link" >>${deployment_path}log.txt
${php_path} artisan storage:link

#Optimizers
${php_path} /opt/cpanel/composer/bin/composer install --optimize-autoloader --no-dev
${php_path} artisan config:clear
${php_path} artisan config:cache
${php_path} artisan route:clear
${php_path} artisan route:cache
${php_path} artisan view:clear
${php_path} artisan view:cache

#Put the site into live mode
echo "`date`- Run ${php_path} artisan up" >>${deployment_path}log.txt
${php_path} artisan up

#Changing directory to make backup and cleanup
echo "`date`- Back up previous deployment and move it to releases directory" >>${deployment_path}log.txt
cd ${deployment_path}
n=`ls -rt | grep deploy | wc -l`
i=1
#echo $n
for f in `ls -rt | grep deploy`; do
   if [ $i -lt $n ];then
      echo $i
      echo "FileDirectory -> $f"
      echo "Creating tarball file"
      tar zcf "$f.tgz" "$f"
      mv "$f.tgz" releases/
      rm -rf "$f"
   fi
   i=$((i+1))
done
#Getting into it again
cd ${deployment_path}current/

#Creating link
echo "`date`- Making sure storage link is created" >>${deployment_path}log.txt
${php_path} artisan storage:link

#COMPLETED
echo "`date`- COMPLETED Deployment No $BUILD_NUMBER" >>${deployment_path}log.txt
