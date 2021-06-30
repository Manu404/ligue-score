import { Component, OnInit } from '@angular/core';
import { GeneralRanking } from '../model/general_ranking';


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  displayedColumns: string[] = ['demo-rank', 'demo-name', 'demo-score'];
  results: GeneralRanking[] = [{
    name: "test",
    rank: 1,
    score: 10
  },{
    name: "test2",
    rank: 2,
    score: 5
  },{
    name: "test3",
    rank: 3,
    score: 3
  }];

  constructor() { }

  ngOnInit(): void {
  }

}
