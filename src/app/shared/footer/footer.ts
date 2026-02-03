import { Component, ElementRef, ViewChild, inject } from '@angular/core';
import { RouterLink } from '@angular/router';
import { TranslateService, TranslateModule } from '@ngx-translate/core';
import { SectionDivider } from '../section-divider/section-divider';
import { PortfolioInfoService } from '../services/portfolio-info.service';

@Component({
  selector: 'app-footer',
  imports: [TranslateModule, RouterLink, SectionDivider],
  templateUrl: './footer.html',
  styleUrl: './footer.scss'
})
export class Footer {
  @ViewChild('contentContainer', { static: true }) contentContainerRef!: ElementRef;

  public portfolioInfo = inject(PortfolioInfoService);
  private translate = inject(TranslateService);
}
