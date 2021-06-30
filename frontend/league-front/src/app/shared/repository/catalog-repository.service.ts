import { Injectable } from '@angular/core';
import { of } from 'rxjs';
import { Observable, Observer } from 'rxjs';
import { map } from 'rxjs/operators';
import { Catalog } from '../model/catalog';
import { FacadeService } from '../service/facade.service';


@Injectable({
  providedIn: 'root'
})
export class CatalogRepositoryService {

  private initialized: boolean = false;
  public Catalog: Catalog[] = [];
  private catalogObserver: Observable<Catalog>;

  constructor(private facade: FacadeService) { 
    this.catalogObserver = Observable.create((observer: Observer<Catalog>) => {
      this.Catalog = [];
      this.facade.GetCatalog().pipe(map(res => res)).subscribe( value => {
        this.Catalog.push(value);
        observer.next(value);
        observer.complete();
        this.initialized = true;
      } 
      );
    });
  }

  public Initialize(): Observable<Catalog>{
    if(this.initialized) return of(this.Catalog[0]);
    return this.Get();
  }

  public Get(): Observable<Catalog> {
    if(!this.initialized)
      return this.Refresh();
    return of(this.Catalog[0]);
  }

  public Refresh(): Observable<Catalog> {
    return this.catalogObserver;
  }
}
