<div class="comprehensive-dashboard">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;400;500;600;700&display=swap");
        
        .comprehensive-dashboard {
            font-family: "Arial", Arial, sans-serif;
            color: white;
            padding: 1rem;
            background: black;
            color: white0c;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .dashboard-title {
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 500;
        }
        
        .section-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .metric-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            padding: 1rem;
            transition: transform 0.2s;
        }
        
        .metric-card:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .metric-title {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.5rem;
        }
        
        .metric-value {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .metric-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }
        
        .metric-change.up {
            color: #10b981;
        }
        
        .metric-change.down {
            color: #ef4444;
        }
        
        .chart-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1rem;
        }
        
        .chart-wrapper {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            padding: 1rem;
        }
        
        .chart-title {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        
        .table-wrapper {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            text-align: left;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
        }
        
        .data-table td {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tr:hover td {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .drilldown-btn {
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.5);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .drilldown-btn:hover {
            background: rgba(59, 130, 246, 0.3);
        }
        
        .assessment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .assessment-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            padding: 1.5rem;
        }
        
        .assessment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .assessment-title {
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .assessment-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .assessment-metric {
            margin-bottom: 1rem;
        }
        
        .assessment-metric-title {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.25rem;
        }
        
        .assessment-metric-value {
            font-size: 1.25rem;
            font-weight: 500;
        }
        
        .no-data {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            padding: 1rem;
        }
        
        @media (max-width: 768px) {
            .section-content {
                grid-template-columns: 1fr;
            }
            
            .chart-container {
                grid-template-columns: 1fr;
            }
            
            .assessment-grid {
                grid-template-columns: 1fr;
            }
            
            .assessment-content {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-header">
        <div>
            <div class="dashboard-title">Comprehensive Patient Dashboard</div>
        </div>
    </div>

    <!-- Demographics Section -->
    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Patient Demographics</h3>
        </div>
        
        <div class="section-content">
            @if(isset($demographics['total_patients']) && $demographics['total_patients'] > 0)
                <div class="metric-card">
                    <div class="metric-title">Total Patients</div>
                    <div class="metric-value">{{ number_format($demographics['total_patients']) }}</div>
                    <div class="metric-change up">+2.5% from last month</div>
                </div>
                
                @foreach($demographics['age_distribution'] ?? [] as $age => $count)
                    <div class="metric-card">
                        <div class="metric-title">Age: {{ $age }}</div>
                        <div class="metric-value">{{ number_format($count) }}</div>
                        <div class="metric-change">
                            {{ $demographics['total_patients'] > 0 ? round(($count / $demographics['total_patients']) * 100, 1) : 0 }}% of total
                        </div>
                    </div>
                @endforeach
                
                @foreach($demographics['gender_distribution'] ?? [] as $gender => $count)
                    <div class="metric-card">
                        <div class="metric-title">Gender: {{ $gender }}</div>
                        <div class="metric-value">{{ number_format($count) }}</div>
                        <div class="metric-change">
                            {{ $demographics['total_patients'] > 0 ? round(($count / $demographics['total_patients']) * 100, 1) : 0 }}% of total
                        </div>
                    </div>
                @endforeach
                
                @foreach($demographics['scheme_distribution'] ?? [] as $scheme => $count)
                    <div class="metric-card">
                        <div class="metric-title">Scheme: {{ $scheme }}</div>
                        <div class="metric-value">{{ number_format($count) }}</div>
                        <div class="metric-change">
                            {{ $demographics['total_patients'] > 0 ? round(($count / $demographics['total_patients']) * 100, 1) : 0 }}% of total
                        </div>
                    </div>
                @endforeach
                
                @foreach($demographics['status_distribution'] ?? [] as $status => $count)
                    <div class="metric-card">
                        <div class="metric-title">Status: {{ $status }}</div>
                        <div class="metric-value">{{ number_format($count) }}</div>
                        <div class="metric-change">
                            {{ $demographics['total_patients'] > 0 ? round(($count / $demographics['total_patients']) * 100, 1) : 0 }}% of total
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-data">No patient data available.</div>
            @endif
        </div>
        
        <div class="chart-container">
            <div class="chart-wrapper">
                <div class="chart-title">Age Distribution</div>
                @if(isset($demographics['age_distribution']) && array_sum($demographics['age_distribution']) > 0)
                    <div id="ageDistributionChart"></div>
                @else
                    <div class="no-data">No age distribution data available.</div>
                @endif
            </div>
            
            <div class="chart-wrapper">
                <div class="chart-title">Gender Distribution</div>
                @if(isset($demographics['gender_distribution']) && array_sum($demographics['gender_distribution']) > 0)
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Gender</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($demographics['gender_distribution'] ?? [] as $gender => $count)
                                    <tr>
                                        <td>{{ $gender }}</td>
                                        <td>{{ number_format($count) }}</td>
                                        <td>{{ $demographics['total_patients'] > 0 ? round(($count / $demographics['total_patients']) * 100, 1) : 0 }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="no-data">No gender distribution data available.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Assessment Results Section -->
    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Assessment Results</h3>
        </div>
        
        <div class="assessment-grid">
            <!-- Chronic Conditions -->
            <div class="assessment-card">
                <div class="assessment-header">
                    <h4 class="assessment-title">Chronic Conditions</h4>
                </div>
                
                @if(isset($assessments['chronic']['total']) && $assessments['chronic']['total'] > 0)
                    <div class="assessment-content">
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Total Assessments</div>
                                <div class="assessment-metric-value">{{ $assessments['chronic']['total'] }}</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">High Compliance</div>
                                <div class="assessment-metric-value">{{ $assessments['chronic']['high_compliance'] }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Low Compliance</div>
                                <div class="assessment-metric-value">{{ $assessments['chronic']['low_compliance'] }}</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">New Cases</div>
                                <div class="assessment-metric-value">{{ $assessments['chronic']['new_cases'] }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="chronicConditionsChart"></div>
                @else
                    <div class="no-data">No chronic conditions data available.</div>
                @endif
            </div>
            
            <!-- Nutrition -->
            <div class="assessment-card">
                <div class="assessment-header">
                    <h4 class="assessment-title">Nutrition Assessment</h4>
                </div>
                
                @if(isset($assessments['nutrition']['total']) && $assessments['nutrition']['total'] > 0)
                    <div class="assessment-content">
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Total Assessments</div>
                                <div class="assessment-metric-value">{{ $assessments['nutrition']['total'] }}</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Average BMI</div>
                                <div class="assessment-metric-value">{{ round($assessments['nutrition']['avg_bmi'], 1) }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Underweight</div>
                                <div class="assessment-metric-value">{{ $assessments['nutrition']['underweight'] }}</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Overweight+</div>
                                <div class="assessment-metric-value">{{ $assessments['nutrition']['overweight'] + $assessments['nutrition']['obese'] }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="nutritionAssessmentChart"></div>
                @else
                    <div class="no-data">No nutrition assessment data available.</div>
                @endif
            </div>
            
            <!-- Psychosocial -->
            <div class="assessment-card">
                <div class="assessment-header">
                    <h4 class="assessment-title">Psychosocial Assessment</h4>
                </div>
                
                @if(isset($assessments['psychosocial']['total']) && $assessments['psychosocial']['total'] > 0)
                    <div class="assessment-content">
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Total Assessments</div>
                                <div class="assessment-metric-value">{{ $assessments['psychosocial']['total'] }}</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Avg Self-Esteem</div>
                                <div class="assessment-metric-value">{{ round($assessments['psychosocial']['avg_self_esteem'], 1) }}/10</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Substance Users</div>
                                <div class="assessment-metric-value">{{ $assessments['psychosocial']['substance_users'] }}</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Avg Coping Ability</div>
                                <div class="assessment-metric-value">{{ round($assessments['psychosocial']['avg_coping'], 1) }}/10</div>
                            </div>
                        </div>
                    </div>
                    <div id="psychosocialAssessmentChart"></div>
                @else
                    <div class="no-data">No psychosocial assessment data available.</div>
                @endif
            </div>
            
            <!-- Physiotherapy -->
            <div class="assessment-card">
                <div class="assessment-header">
                    <h4 class="assessment-title">Physiotherapy</h4>
                </div>
                
                @if(isset($assessments['physiotherapy']['total']) && $assessments['physiotherapy']['total'] > 0)
                    <div class="assessment-content">
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Total Assessments</div>
                                <div class="assessment-metric-value">{{ $assessments['physiotherapy']['total'] }}</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Avg Pain Level</div>
                                <div class="assessment-metric-value">{{ round($assessments['physiotherapy']['avg_pain'], 1) }}/10</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Avg Mobility</div>
                                <div class="assessment-metric-value">{{ round($assessments['physiotherapy']['avg_mobility'], 1) }}/10</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Avg Strength</div>
                                <div class="assessment-metric-value">{{ round($assessments['physiotherapy']['avg_strength'], 1) }}/10</div>
                            </div>
                        </div>
                    </div>
                    <div id="physioAssessmentChart"></div>
                @else
                    <div class="no-data">No physiotherapy assessment data available.</div>
                @endif
            </div>
            
            <!-- Medication Use -->
            <div class="assessment-card">
                <div class="assessment-header">
                    <h4 class="assessment-title">Medication Use</h4>
                </div>
                
                @if(isset($assessments['medication']['total']) && $assessments['medication']['total'] > 0)
                    <div class="assessment-content">
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Total Records</div>
                                <div class="assessment-metric-value">{{ $assessments['medication']['total'] }}</div>
                            </div>
                            
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Unique Medications</div>
                                <div class="assessment-metric-value">{{ $assessments['medication']['unique_meds'] }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="assessment-metric">
                                <div class="assessment-metric-title">Avg Days Supplied</div>
                                <div class="assessment-metric-value">{{ round($assessments['medication']['avg_days_supplied'], 1) }}</div>
                            </div>
                        </div>
                    </div>
                    <div id="medicationUseChart"></div>
                @else
                    <div class="no-data">No medication use data available.</div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($demographics['age_distribution']) && array_sum($demographics['age_distribution']) > 0)
                // Placeholder for age distribution chart (ApexCharts integration)
            @endif
        });
    </script>
</div>
