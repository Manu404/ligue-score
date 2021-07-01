import { Component, OnInit } from '@angular/core';
import { CatalogRepositoryService } from 'src/app/shared/repository/catalog-repository.service';
import { GameRepositoryService } from 'src/app/shared/repository/match-repository.service';
import { LoadingService } from 'src/app/shared/service/loading.service';
import { MatSort } from '@angular/material/sort';
import { faTrophy, faSync } from '@fortawesome/free-solid-svg-icons';

export class GameSummaryPlayerResult {
  constructor(public Name:string, public Score: number) {}
}
export class GameSummaryLine {
  constructor(public Id:number, public Date:Date, public Results:GameSummaryPlayerResult[]) {}
}

@Component({
  selector: 'app-matchs',
  templateUrl: './match-list.component.html',
  styleUrls: ['./match-list.component.scss']
})
export class MatchListComponent implements OnInit {

  faTrophy = faTrophy;
  faSync = faSync;

  summaryLines:GameSummaryLine[] = [];

  constructor(private gameRepository:GameRepositoryService, private loadingService: LoadingService, private catalogRepository: CatalogRepositoryService) { }

  ngOnInit(): void {
    this.getMatchSummary();
  }
  
  getMatchSummary(): void {
    this.loadingService.IsLoading = true;
    this.gameRepository.GetGamesSummary().subscribe(gameSummary => { 
      this.catalogRepository.Get().subscribe(catalog => {
          this.gameRepository.GetGames().subscribe(games => {

          this.summaryLines = [];
          var currentLine = new GameSummaryLine(-1, new Date(), []);

          gameSummary.sort((a, b) => ((b.gameid - a.gameid)*100) - (a.total - b.total)).forEach(summary => {
            if(summary.gameid != currentLine.Id) {  
              if(currentLine.Id > 0) this.summaryLines.push(currentLine);
              var game = games.find(g => g.id == summary.gameid);
              var day = catalog.days.find(d => d.id == game?.dayid);
              currentLine = new GameSummaryLine(summary.gameid, day === undefined ? new Date() : day.date, [])
            }

            var player = catalog.players.find(p  => p.id == summary.playerid);
            var playerName = player === undefined ? "" : player.name;
            currentLine.Results.push(new GameSummaryPlayerResult(playerName, summary.total));
          });

          this.summaryLines.push(currentLine);
          this.loadingService.IsLoading = false;

        });
      });
    });
  }

  refreshGeneralRanking(): void {
    this.loadingService.IsLoading = true;
    this.gameRepository.RefreshGamesSummary().subscribe(result => {
      this.getMatchSummary();
    });
  }
}
