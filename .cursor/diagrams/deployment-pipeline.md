# BCN Deployment Pipeline

```mermaid
gitgraph
    commit id: "Initial Commit"
    branch develop
    checkout develop
    commit id: "Feature: Member Cards"
    commit id: "Feature: Event Calendar"
    branch feature/member-directory
    checkout feature/member-directory
    commit id: "Enhanced Member Directory"
    commit id: "Filtering System"
    checkout develop
    merge feature/member-directory
    commit id: "Merge: Member Directory"
    checkout main
    merge develop
    commit id: "Release v1.0.0"
    tag: "v1.0.0"
```

## CI/CD Pipeline Flow

```mermaid
flowchart LR
    A[Code Push] --> B[GitHub Actions Trigger]
    B --> C[Code Quality Checks]
    C --> D{Tests Pass?}
    D -->|No| E[Report Failure]
    D -->|Yes| F[Build Assets]
    F --> G[Security Scan]
    G --> H{Security OK?}
    H -->|No| E
    H -->|Yes| I[Deploy to Staging]
    I --> J[Health Checks]
    J --> K{Staging OK?}
    K -->|No| L[Rollback]
    K -->|Yes| M[Performance Test]
    M --> N{Performance OK?}
    N -->|No| L
    N -->|Yes| O[Deploy to Production]
    O --> P[Final Verification]
    P --> Q[Success Notification]
    
    style A fill:#4A90E2,color:#fff
    style Q fill:#28a745,color:#fff
    style E fill:#dc3545,color:#fff
    style L fill:#ffc107,color:#000
```

## Background Agents Workflow

```mermaid
sequenceDiagram
    participant Dev as Developer
    participant Git as Git Repository
    participant GA as GitHub Actions
    participant Agent as Background Agent
    participant Staging as Staging Server
    participant Prod as Production Server
    
    Dev->>Git: Push Code
    Git->>GA: Trigger Workflow
    GA->>Agent: Start Code Quality Agent
    Agent->>Agent: Run PHPCS, ESLint
    Agent->>GA: Report Results
    GA->>Agent: Start Performance Agent
    Agent->>Staging: Run Lighthouse Audit
    Agent->>GA: Report Performance
    GA->>Agent: Start Deployment Agent
    Agent->>Staging: Deploy Code
    Agent->>Staging: Health Check
    Agent->>GA: Report Status
    GA->>Agent: Start Content Agent
    Agent->>Staging: Sync ACF Fields
    Agent->>GA: Report Success
    GA->>Dev: Notify Completion
```