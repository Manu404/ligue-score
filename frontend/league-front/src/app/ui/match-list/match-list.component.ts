import { Component, OnInit } from '@angular/core';
import { CatalogRepositoryService } from 'src/app/shared/repository/catalog-repository.service';
import { MatchRepositoryService } from 'src/app/shared/repository/match-repository.service';
import { LoadingService } from 'src/app/shared/service/loading.service';
import { MatSort } from '@angular/material/sort';
import { faTrophy, faSync } from '@fortawesome/free-solid-svg-icons';

export class MatchSummaryDetail {
  constructor(public Name:string, public Score: number) {}
}
export class MatchSummaryLine {
  constructor(public Id:number, public Results:MatchSummaryDetail[]) {}
}


@Component({
  selector: 'app-matchs',
  templateUrl: './match-list.component.html',
  styleUrls: ['./match-list.component.scss']
})
export class MatchListComponent implements OnInit {

  faTrophy = faTrophy;
  faSync = faSync;

  summaryLines:MatchSummaryLine[] = [];

  constructor(private matchRepository:MatchRepositoryService, private loadingService: LoadingService, private catalogRepository: CatalogRepositoryService) { }

  ngOnInit(): void {
    this.getMatchSummary();
  }
  
  getMatchSummary(): void {
    this.loadingService.IsLoading = true;
    this.matchRepository.GetMatchSummary()
      .subscribe(matchSummaries => { 
        this.catalogRepository.Get().subscribe(catalog => {
          this.summaryLines = [];
          var currentLine = new MatchSummaryLine(-1, []);
          matchSummaries.sort((a, b) => ((a.gameid - b.gameid) * 100) + (b.total - a.total)).forEach(summary => {

            if(summary.gameid != currentLine.Id){  
              if(currentLine.Id > 0)            
                this.summaryLines.push(currentLine);
              currentLine = new MatchSummaryLine(summary.gameid, [])
            }

            var player = catalog.players.find(p  => p.id == summary.playerid);
            var playerName = player === undefined ? "" : player.name;
            currentLine.Results.push(new MatchSummaryDetail(playerName, summary.total));
          });
          this.summaryLines.push(currentLine);
          this.loadingService.IsLoading = false;
        });
    });
  }

  refreshGeneralRanking(): void {
    this.loadingService.IsLoading = true;
    this.matchRepository.RefreshMatchSummary().subscribe(result => {
      this.getMatchSummary();
    });
  }
}
