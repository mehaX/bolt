using Microsoft.Extensions.Caching.Memory;
using NewsAPI;
using NewsAPI.Constants;
using NewsAPI.Models;

namespace Bolt.WebApi.Services;

public class NewsApiService
{
    private readonly IMemoryCache mMemoryCache;
    private readonly NewsApiClient mNewsApiClient;

    public NewsApiService(IConfiguration configuration, IMemoryCache memoryCache)
    {
        mMemoryCache = memoryCache;
        var token = configuration.GetSection("NewsApiToken").Value;
        mNewsApiClient = new NewsApiClient(token);
    }

    public List<Article> GetEverything(string query, Languages language = Languages.EN)
    {
        var cacheKey = "everything/" + Base64Encode(query);

        if (mMemoryCache.TryGetValue(cacheKey, out List<Article> existing))
        {
            return existing;
        }
        
        var request = new EverythingRequest()
        {
            Q = query,
            Language = language,
        };
        var response = mNewsApiClient.GetEverything(request);

        if (response.Status != Statuses.Ok)
        {
            throw new BadHttpRequestException($"Error: {response.Error.Message}");
        }

        var expiration = TimeSpan.FromMinutes(60 - DateTime.Now.Minute);
        mMemoryCache.Set(cacheKey, response.Articles, expiration);
        
        return response.Articles;
    }
    
    private static string Base64Encode(string plainText) {
        var plainTextBytes = System.Text.Encoding.UTF8.GetBytes(plainText);
        return System.Convert.ToBase64String(plainTextBytes);
    }
}