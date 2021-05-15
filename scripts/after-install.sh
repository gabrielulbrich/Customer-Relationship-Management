cd /var/www/crm-vue
npm run build
now=$(date)

##API
chmod 775 -R /var/www/crm-lumen/storage/

cd ~/log
echo "Script executado em $now" > log
