import { Component, OnInit } from '@angular/core';
import { GeneralRanking } from '../../shared/model/general_ranking';


import { faTrophy, faSync } from '@fortawesome/free-solid-svg-icons';
import { MessageService } from '../../shared/service/message.service';
import { RankingRepositoryService } from '../../shared/repository/ranking-repository.service';
import { LoadingService } from '../../shared/service/loading.service';
import { delay, map } from 'rxjs/operators';
import { CatalogRepositoryService } from 'src/app/shared/repository/catalog-repository.service';
import { ValueConverter } from '@angular/compiler/src/render3/view/template';

export class GeneralRankingLine {

  constructor(public Rank:Number, public Name:string, public Score: number) {}
}

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  faTrophy = faTrophy;
  faSync = faSync;
  rankings: GeneralRankingLine[] = [];

  constructor(private rankingService: RankingRepositoryService, private loadingService: LoadingService, private catalogRepository: CatalogRepositoryService) {
  }

  ngOnInit(): void {
    this.getGeneralRanking();
  }  
  
  getGeneralRanking(): void {
    this.loadingService.IsLoading = true;
    this.rankingService.Get()
      .subscribe(generalRanking => { 
        this.catalogRepository.Get().subscribe(catalog => {
          this.rankings = [];
          generalRanking.forEach(ranking => {
            var player = catalog.players.find(p  => p.id == ranking.id);
            this.rankings.push(new GeneralRankingLine(ranking.rank, player === undefined ? "" : player.name, ranking.score));
          });
          this.loadingService.IsLoading = false;
        });
    });
  }

  refreshGeneralRanking(): void {
    this.loadingService.IsLoading = true;
    this.rankingService.Refresh().subscribe(result => {
      this.getGeneralRanking();
    });
  }

}
