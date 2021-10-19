chmod +x bin/console
settingUpDb() {
  echo "SETTING UP THE DB..."
  if [ ! -f ".db-created" ]; then
    bin/console doctrine:schema:create && touch .db-created
  else
    bin/console doctrine:schema:update --force
  fi
}

until settingUpDb;
do
  settingUpDb
  sleep 5
done