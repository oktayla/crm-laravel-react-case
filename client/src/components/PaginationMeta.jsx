import { Button } from '@/components/ui/button'

const PaginationMeta = ({ meta, handlePageChange }) => {
  if (!meta) return null

  return (
    <div className="flex justify-between items-center mt-4">
      <div className="text-sm">
        Showing {(meta.current_page - 1) * meta.per_page + 1} to {Math.min(meta.current_page * meta.per_page, meta.total)} of {meta.total} customers
      </div>
      <div className="space-x-2">
        <Button
          onClick={() => handlePageChange(meta.current_page - 1)}
          disabled={meta.current_page === 1}
        >
          Previous
        </Button>
        <Button
          onClick={() => handlePageChange(meta.current_page + 1)}
          disabled={!meta.has_next}
        >
          Next
        </Button>
      </div>
    </div>
  );
}

export default PaginationMeta
