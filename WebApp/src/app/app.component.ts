import {Component, OnDestroy, OnInit} from '@angular/core';
import {FormBuilder, FormGroup} from "@angular/forms";
import {NewsService} from "./api/services/news.service";
import {take, takeUntil} from "rxjs/operators";
import {Subject} from "rxjs";
import {Article} from "./api/models/article";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit, OnDestroy {
  title = 'bolt';

  searchForm: FormGroup = this.formBuilder.group({
    query: 'kosovo'
  });
  articles: Array<Article> = [];

  private destroyed$: Subject<boolean> = new Subject<boolean>();

  constructor(private formBuilder: FormBuilder, private newsService: NewsService) {}

  ngOnInit(): void {
  }

  onSubmit(): void {
    this.newsService.apiNewsGet$Json$Response({query: this.searchForm.value})
      .pipe(take(1), takeUntil(this.destroyed$))
      .subscribe(response =>
      {
        this.articles = response.body
      });
  }

  ngOnDestroy(): void {
    this.destroyed$.next();
    this.destroyed$.complete();
  }
}
