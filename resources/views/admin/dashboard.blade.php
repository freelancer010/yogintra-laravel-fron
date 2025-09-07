@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@include('admin.partials.flash')

<div class="content-wrapper m-0">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6 col-12">
               <h1 class="m-0">Dashboard</h1>
            </div>
         </div>
      </div>
   </div>

   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-3 col-6">
               <div class="small-box bg-info">
                  <div class="inner">
                     <h3>{{ $eventCount }}</h3>
                     <p>Total Events</p>
                  </div>
                  <div class="icon">
                     <i class="fa fa-calendar"></i>
                  </div>
                  <a href="{{ url('/admin/event/view_all_event') }}" class="small-box-footer">
                     More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
               </div>
            </div>

            <div class="col-lg-3 col-6">
               <div class="small-box bg-primary">
                  <div class="inner">
                     <h3>{{ $serviceCount }}</h3>
                     <p>Total Service</p>
                  </div>
                  <div class="icon">
                     <i class="fa fa-wrench"></i>
                  </div>
                  <a href="{{ url('/admin/service/all_service') }}" class="small-box-footer">
                     More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
               </div>
            </div>

            <div class="col-lg-3 col-6">
               <div class="small-box bg-warning">
                  <div class="inner">
                     <h3>{{ $yogaCenterCount }}</h3>
                     <p>Total Yoga Center</p>
                  </div>
                  <div class="icon">
                     <i class="fa fa-building"></i>
                  </div>
                  <a href="{{ url('/admin/yoga_center/view_all_yoga_center') }}" class="small-box-footer">
                     More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
               </div>
            </div>

            <div class="col-lg-3 col-6">
               <div class="small-box bg-success">
                  <div class="inner">
                     <h3>{{ $blogCount }}</h3>
                     <p>Total Blog</p>
                  </div>
                  <div class="icon">
                     <i class="fab fa-blogger"></i>
                  </div>
                  <a href="{{ url('/admin/blog/view-all-post') }}" class="small-box-footer">
                     More info <i class="fas fa-arrow-circle-right"></i>
                  </a>
               </div>
            </div>
         </div>

         <div class="row mt-3">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <h3 class="card-title">Site Management</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6">
                           <a href="{{ route('sitemap.generate') }}" class="btn btn-success">
                              <i class="fas fa-sitemap"></i> Generate Sitemap
                           </a>
                           <small class="text-muted ml-2">Click to regenerate the XML sitemap for search engines</small>
                           
                           @php
                              $sitemapPath = public_path('sitemap.xml');
                              $sitemapExists = file_exists($sitemapPath);
                              
                              // Try to get stats from cache first (updated when sitemap is generated)
                              $cachedStats = \Cache::get('sitemap_stats');
                              
                              $sitemapStats = [
                                 'exists' => $sitemapExists,
                                 'size' => $sitemapExists ? round(filesize($sitemapPath) / 1024, 2) . ' KB' : '0 KB',
                                 'modified' => $sitemapExists ? date('Y-m-d H:i:s', filemtime($sitemapPath)) : 'N/A',
                                 'url_count' => 0,
                                 'trainer_url_count' => 0,
                                 'last_generation' => $cachedStats['updated_at'] ?? null,
                                 'xml_snippet' => $cachedStats['xml_snippet'] ?? null
                              ];
                              
                              // If we have cached stats, use those
                              if ($cachedStats) {
                                 $sitemapStats['url_count'] = $cachedStats['total_urls'] ?? 0;
                                 $sitemapStats['trainer_url_count'] = $cachedStats['trainer_urls'] ?? 0;
                                 $sitemapStats['size'] = $cachedStats['file_size'] ?? $sitemapStats['size'];
                              } 
                              // Otherwise read from file
                              elseif($sitemapExists) {
                                 $content = file_get_contents($sitemapPath);
                                 $sitemapStats['url_count'] = substr_count($content, '<url>');
                                 $sitemapStats['trainer_url_count'] = substr_count($content, '/trainer/');
                                 
                                 // Create XML snippet if it doesn't exist in cache
                                 if (empty($sitemapStats['xml_snippet'])) {
                                    if (preg_match('/<urlset[^>]*>(.*?<\/url>){1,10}/s', $content, $matches)) {
                                        $sitemapStats['xml_snippet'] = $matches[0] . '...';
                                        // Add closing tag if we have content
                                        if (!empty($sitemapStats['xml_snippet'])) {
                                            $sitemapStats['xml_snippet'] .= "\n</urlset>";
                                        }
                                    }
                                 }
                              }
                           @endphp
                        </div>
                        
                        <div class="col-md-6">
                           <div class="card bg-light">
                              <div class="card-header">
                                 <h3 class="card-title">Current Sitemap Info</h3>
                                 @if($sitemapStats['exists'])
                                    @if($sitemapStats['trainer_url_count'] > 0)
                                       <span class="badge badge-success float-right">Healthy</span>
                                    @else
                                       <span class="badge badge-warning float-right">Missing Trainers</span>
                                    @endif
                                 @else
                                    <span class="badge badge-danger float-right">Missing</span>
                                 @endif
                              </div>
                              <div class="card-body p-0">
                                 <table class="table table-sm">
                                    <tr>
                                       <td>Status:</td>
                                       <td>
                                          @if($sitemapStats['exists'])
                                             <span class="badge badge-success">Available</span>
                                          @else
                                             <span class="badge badge-danger">Missing</span>
                                          @endif
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Last Updated:</td>
                                       <td>{{ $sitemapStats['modified'] }}</td>
                                    </tr>
                                    <tr>
                                       <td>Last Generated:</td>
                                       <td>
                                          @if($sitemapStats['last_generation'])
                                             {{ $sitemapStats['last_generation']->diffForHumans() }}
                                             <small class="text-muted">({{ $sitemapStats['last_generation'] }})</small>
                                          @else
                                             <span class="text-muted">Unknown</span>
                                          @endif
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Size:</td>
                                       <td>{{ $sitemapStats['size'] }}</td>
                                    </tr>
                                    <tr>
                                       <td>Total URLs:</td>
                                       <td>{{ $sitemapStats['url_count'] }}</td>
                                    </tr>
                                    <tr>
                                       <td>Trainer URLs:</td>
                                       <td>
                                          {{ $sitemapStats['trainer_url_count'] }}
                                          @if($sitemapStats['trainer_url_count'] == 0 && $sitemapStats['exists'])
                                             <span class="badge badge-warning">Missing!</span>
                                             <small class="d-block text-danger">
                                                Trainers are missing. Try regenerating the sitemap or check the API connection.
                                             </small>
                                          @endif
                                       </td>
                                    </tr>
                                 </table>
                              </div>
                              <div class="card-footer p-2">
                                 <div class="btn-group">
                                    <a href="{{ url('sitemap.xml') }}" target="_blank" class="btn btn-sm btn-info">
                                       <i class="fas fa-external-link-alt"></i> View Sitemap
                                    </a>
                                    <a href="{{ route('sitemap.generate') }}" class="btn btn-sm btn-warning">
                                       <i class="fas fa-sync"></i> Regenerate
                                    </a>
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="collapse" data-target="#xmlPreview">
                                       <i class="fas fa-code"></i> XML Preview
                                    </button>
                                 </div>
                              </div>
                           </div>
                           
                           <!-- XML Preview Section (Collapsible) -->
                           <div class="collapse mt-2" id="xmlPreview">
                              <div class="card bg-dark text-light">
                                 <div class="card-header">
                                    <h5 class="card-title">Sitemap XML Preview <small class="text-muted">(First 10 URLs)</small></h5>
                                 </div>
                                 <div class="card-body p-2">
                                    @if($sitemapStats['exists'] && !empty($sitemapStats['xml_snippet']))
                                       <pre style="max-height: 300px; overflow-y: auto; font-size: 12px; white-space: pre-wrap; background-color: #282c34; color: #e6e6e6; padding: 10px; border-radius: 5px;"><code>{{ htmlspecialchars($sitemapStats['xml_snippet']) }}</code></pre>
                                    @else
                                       <div class="alert alert-warning">
                                          No XML preview available. Please generate the sitemap first.
                                       </div>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           
                           <!-- Static XML Preview (Always Visible) -->
                           <div class="card mt-3">
                              <div class="card-header bg-secondary text-white">
                                 <h3 class="card-title">Sitemap XML Content</h3>
                              </div>
                              <div class="card-body">
                                 @if($sitemapStats['exists'])
                                    <div class="xml-container" style="position: relative;">
                                       <pre style="max-height: 400px; overflow-y: auto; font-size: 12px; white-space: pre-wrap; background-color: #f8f9fa; border: 1px solid #ddd; padding: 15px; border-radius: 5px;"><code>{{ htmlspecialchars($sitemapStats['xml_snippet'] ?? file_get_contents($sitemapPath)) }}</code></pre>
                                       
                                       <!-- Copy Button -->
                                       <button onclick="copyToClipboard('xml-content')" class="btn btn-sm btn-outline-secondary" style="position: absolute; top: 10px; right: 10px;">
                                          <i class="fas fa-copy"></i> Copy
                                       </button>
                                    </div>
                                    <script>
                                    function copyToClipboard(elementId) {
                                       const xmlContent = document.querySelector('.xml-container pre').innerText;
                                       const textArea = document.createElement('textarea');
                                       textArea.value = xmlContent;
                                       document.body.appendChild(textArea);
                                       textArea.select();
                                       document.execCommand('copy');
                                       document.body.removeChild(textArea);
                                       
                                       // Show temporary success message
                                       const btn = event.target.closest('button');
                                       const originalText = btn.innerHTML;
                                       btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                                       setTimeout(() => { btn.innerHTML = originalText; }, 2000);
                                    }
                                    </script>
                                 @else
                                    <div class="alert alert-warning">
                                       <i class="fas fa-exclamation-triangle"></i> No sitemap file found. Please generate the sitemap first.
                                    </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection
