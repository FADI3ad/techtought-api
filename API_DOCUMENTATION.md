# TechTought API Documentation

This document describes the API endpoints available in the TechTought platform. All responses follow a unified JSON structure.

## Unified Response Structure
```json
{
  "status": "success",
  "message": "Human readable message",
  "data": {
    "key": "value/object/collection"
  },
  "meta": {
    "total": 0,
    "current_page": 1,
    "per_page": 15
  }
}
```

---

## Authentication
- **Register**: `POST /api/register`
- **Login**: `POST /api/login`
- **Logout**: `POST /api/logout` (Requires Auth)
- **Get User**: `GET /api/user` (Requires Auth)

---

## Categories & SubCategories
- **List Categories**: `GET /api/categories`
- **Navbar Categories**: `GET /api/categories/navbar`
- **Category Details**: `GET /api/categories/{slug}`
- **SubCategories**: `GET /api/subcategories`
- **SubCategory Details**: `GET /api/subcategories/{slug}`

---

## Courses
- **List Courses**: `GET /api/courses`
- **Course Details**: `GET /api/courses/{slug}`
- **Course Content**: `GET /api/courses/{slug}/sections`
- **Top Rated**: `GET /api/top-rated-courses`

---

## Favorites (Requires Auth)
- **List Favorites**: `GET /api/favorites`
- **Add to Favorites**: `POST /api/favorites` (Body: `course_id`)
- **Remove from Favorites**: `DELETE /api/favorites/{id}`

---

## Testimonials
- **List Approved Testimonials**: `GET /api/testimonials` (Public)
- **Submit Testimonial**: `POST /api/testimonials` (Requires Auth, Body: `rating`, `comment`)
- **Admin List**: `GET /api/admin/testimonials` (Admin Only)
- **Admin Toggle Visibility**: `PATCH /api/admin/testimonials/{id}/toggle` (Admin Only)
- **Admin Delete**: `DELETE /api/admin/testimonials/{id}` (Admin Only)

---

## Subscription (Newsletter)
- **Subscribe**: `POST /api/subscribe` (Body: `email`)

---

## My Learning (Enrollments)
- **My Courses**: `GET /api/my-learning` (Requires Auth)
- **Enroll in Course**: `POST /api/enroll` (Requires Auth, Body: `course_id`)

---

## Reviews & Comments
- **Course Comments**: `GET /api/courses/{slug}/comments`
- **Submit Comment**: `POST /api/comments` (Requires Auth)
- **Submit Review**: `POST /api/reviews` (Requires Auth, Body: `course_id`, `rating`, `comment`)

---

## Admin Management (Admin Only)
- Extensive endpoints for managing Categories, SubCategories, Courses, Sections, Lessons, Reviews, and Instructor Requests are available under the `/api/admin` prefix.
