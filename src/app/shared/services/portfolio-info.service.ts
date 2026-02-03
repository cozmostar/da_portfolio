import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class PortfolioInfoService {
  readonly name = 'Sebastian Franke';
  readonly email = 'info@sebastianfranke.com';
  readonly phone = '+49 15678 398880';
  readonly githubUrl = 'https://github.com/cozmostar'; 
  readonly linkedInUrl = 'https://www.linkedin.com/in/sebastianfranke/';
  readonly brandingName = 'Sebastian Franke';
  readonly copyrightYear = new Date().getFullYear();
}
