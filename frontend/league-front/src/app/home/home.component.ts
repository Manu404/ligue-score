import { Component, OnInit } from '@angular/core';
import { GeneralRanking } from '../model/general_ranking';


import { faTrophy, faSync } from '@fortawesome/free-solid-svg-icons';
import { MessageService } from '../service/message.service';
import { RankingRepositoryService } from '../repository/ranking-repository.service';
import { LoadingService } from '../service/loading.service';
import { delay } from 'rxjs/operators';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  faTrophy = faTrophy;
  faSync = faSync;
  rankings: GeneralRanking[] = [];

  constructor(private rankingService: RankingRepositoryService, private loadingService: LoadingService) {
   }

  ngOnInit(): void {
    this.getGeneralRanking();
  }  
  
  getGeneralRanking(): void {
    this.loadingService.IsLoading = true;
    this.rankingService.Get().subscribe(rankings => { 
      this.rankings = this.rankingService.GeneralRankings;
      this.loadingService.IsLoading = false;
    });
  }

}
