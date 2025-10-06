# ER図 - 研究室口コミシステム

```mermaid
erDiagram
    users ||--o{ laboratory_reviews : "投稿する"
    users ||--o{ laboratory_review_helpful : "好評価する"
    laboratories ||--o{ laboratory_reviews : "レビューされる"
    laboratory_reviews ||--o{ laboratory_review_helpful : "好評価される"

    users {
        bigint id PK
        string name "名前"
        string email UK
        timestamp email_verified_at
        string password
        enum status "既卒/在学/その他"
        timestamp created_at
        timestamp updated_at
    }

    laboratories {
        bigint id PK
        string faculty "学部"
        string department "学科"
        string course "コース(nullable)"
        text research_overview "研究概要"
        timestamp created_at
        timestamp updated_at
    }

    laboratory_reviews {
        bigint id PK
        text research_content "研究内容"
        bigint laboratory_id FK "研究室"
        bigint user_id FK "投稿者"
        integer overall_rating "総合評価"
        integer professor_atmosphere "先生の雰囲気"
        integer senior_atmosphere "先輩の雰囲気"
        integer core_time "コアタイム"
        integer laboratory_connection "研究室のコネ"
        integer evaluation_strictness "評価の厳しさ"
        integer job_hunting_situation "就活事情"
        integer research_funding "研究費用の充実度"
        integer conference_frequency "学会への出撃回数"
        integer extracurricular_interaction "研究外での交流"
        integer helpful_count "好評価数"
        timestamp created_at
        timestamp updated_at
    }

    laboratory_review_helpful {
        bigint id PK
        bigint laboratory_review_id FK "レビュー"
        bigint user_id FK "ユーザー"
        timestamp created_at
        timestamp updated_at
    }
```

## リレーションシップ説明

### users (ユーザーDB)
- **1対多**: 1人のユーザーは複数の投稿(laboratory_reviews)を持つ
- **多対多**: ユーザーは複数の投稿に好評価をつけることができる(laboratory_review_helpful経由)

### laboratories (研究室DB)
- **1対多**: 1つの研究室は複数のレビュー(laboratory_reviews)を持つ

### laboratory_reviews (投稿DB)
- **多対1**: 複数のレビューは1つの研究室(laboratories)に属する
- **多対1**: 複数のレビューは1人のユーザー(users)によって投稿される
- **1対多**: 1つのレビューは複数の好評価(laboratory_review_helpful)を持つ

### laboratory_review_helpful (好評価中間テーブル)
- **多対1**: 複数の好評価は1つのレビュー(laboratory_reviews)に属する
- **多対1**: 複数の好評価は1人のユーザー(users)によって付けられる
- **制約**: 同じユーザーが同じレビューに複数回好評価をつけられない(unique制約)

## キー制約

- `laboratory_reviews`: (laboratory_id, user_id) の組み合わせがユニーク（1人のユーザーは1つの研究室に対して1つのレビューのみ）
- `laboratory_review_helpful`: (laboratory_review_id, user_id) の組み合わせがユニーク（1人のユーザーは1つのレビューに対して1回のみ好評価可能）
