using Bolt.WebApi.Services;
using Microsoft.AspNetCore.Mvc;
using NewsAPI.Models;

namespace Bolt.WebApi.Controllers;

[ApiController]
[Route("api/[controller]")]
public class NewsController : ControllerBase
{
    private readonly NewsApiService mNewsApiService;

    public NewsController(NewsApiService newsApiService)
    {
        mNewsApiService = newsApiService;
    }
    
    [HttpGet]
    public ActionResult<List<Article>> GetEverything([FromQuery] string? query)
    {
        return Ok(mNewsApiService.GetEverything(query));
    }
}