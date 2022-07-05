FROM mcr.microsoft.com/dotnet/sdk:6.0 AS build
WORKDIR /api
COPY WebApi/Bolt.WebApi .
RUN dotnet restore
RUN dotnet publish -c Release -o /out

FROM node:14.17.0 as front
WORKDIR /app
COPY WebApp .
RUN npm install
RUN npm run build --prod

FROM mcr.microsoft.com/dotnet/aspnet:6.0 as base
WORKDIR /app
COPY --from=build /out .
COPY --from=front /app/dist/bolt wwwroot
ENTRYPOINT [ "dotnet", "/app/Bolt.WebApi.dll" ]
EXPOSE 80