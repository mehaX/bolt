rm -rf dist
mkdir dist

dotnet build -c Release -o dist/backend WebApi/Bolt.WebApi/Bolt.WebApi.csproj

cd WebApp
npm run build --prod

cd ..
cp -r WebApp/dist/bolt dist/out/wwwroot
