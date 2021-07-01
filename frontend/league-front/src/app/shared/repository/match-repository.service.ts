import { Injectable } from '@angular/core';
import { of } from 'rxjs';
import { Observable, Observer } from 'rxjs';
import { map } from 'rxjs/operators';
import { Catalog } from '../model/catalog';
import { Game, GameSummary } from '../model/game';
import { FacadeService } from '../service/facade.service';


@Injectable({
  providedIn: 'root'
})
export class GameRepositoryService {

  private initialized: boolean = false;
  public GamesSummary: GameSummary[] = [];
  public Games: Game[] = [];

  private gameSummaryObserver: Observable<GameSummary[]>;
  private gameObserver: Observable<Game[]>;

  constructor(private facade: FacadeService) { 
    this.gameSummaryObserver = Observable.create((observer: Observer<GameSummary[]>) => {
      this.GamesSummary = [];
      this.facade.GetGamesSummary().pipe(map(res => res)).subscribe( value => {
        this.GamesSummary = value;
        observer.next(value);
        observer.complete();
        this.initialized = true;
      });
    });

    this.gameObserver = Observable.create((observer: Observer<Game[]>) => {
      this.GamesSummary = [];
      this.facade.GetGames().pipe(map(res => res)).subscribe( value => {
        this.Games = value;
        observer.next(value);
        observer.complete();
        this.initialized = true;
      });
    });
  }

  public GetGamesSummary(): Observable<GameSummary[]> {
    if(!this.initialized)
      return this.RefreshGamesSummary();
    return of(this.GamesSummary);
  }

  public RefreshGamesSummary(): Observable<GameSummary[]> {
    return this.gameSummaryObserver;
  }

  public GetGames(): Observable<Game[]> {
    if(!this.initialized)
      return this.RefreshGames();
    return of(this.Games);
  }

  public RefreshGames(): Observable<Game[]> {
    return this.gameObserver;
  }
}
