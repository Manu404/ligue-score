import { Component, OnInit } from '@angular/core';
import { GeneralRanking } from '../model/general_ranking';


import { faTrophy, faSync } from '@fortawesome/free-solid-svg-icons';
import { MessageService } from '../service/message.service';
import { RankingRepositoryService } from '../repository/ranking-repository.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  displayedColumns: string[] = ['demo-rank', 'demo-name', 'demo-score'];
  faTrophy = faTrophy;
  faSync = faSync;
  rankings: GeneralRanking[] = [];

  constructor(private rankingService: RankingRepositoryService, private messageService: MessageService) {
   }

  ngOnInit(): void {
    this.getGeneralRanking();
  }  
  
  getGeneralRanking(): void {
    this.rankingService.Get().subscribe(rankings => this.rankings = this.rankingService.GeneralRankings );
  }

}
