import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';

import { HomeComponent } from './ui/home/home.component';
import { StatsComponent } from './ui/stats/stats.component';
import { InfosComponent } from './ui/infos/infos.component';
import { MatchListComponent } from './ui/match-list/match-list.component';
import { ContactComponent } from './contact/contact.component';

const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'match', component: MatchListComponent },
  { path: 'stat', component: StatsComponent },
  { path: 'info', component: InfosComponent },
  { path: 'contact', component: ContactComponent },
  { path: '', redirectTo: '/home', pathMatch: 'full' },

];

@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    RouterModule.forRoot(routes)
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
