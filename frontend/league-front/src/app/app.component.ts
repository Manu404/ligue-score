import { Component } from '@angular/core';
import { CatalogRepositoryService } from './shared/repository/catalog-repository.service';
import { LoadingService } from './shared/service/loading.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  events: string[] = [];
  opened: boolean = true;
  title = 'league-front';


  constructor(public loadingService:LoadingService, private catalogRepository:CatalogRepositoryService ) {

   }

   ngOnInit(): void {
    this.catalogRepository.Initialize().subscribe(data => console.log("ok"));
  }  
}
