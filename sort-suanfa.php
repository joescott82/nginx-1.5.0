<?php
$array = array(9, 8, 10, 15, 6, 3, 21, 4, 11);
quick_sort($array, 0, 8);
print_r($array);
/**
 * 原理
 * 1) 比较相邻的两个元素的大小， 如果前面的元素比后面的元素大， 则狡猾两个元素
 * 2) 对每一对元素做同样的工作， 从开始第一对到结尾最后一对。 在这一点， 最后的元素应该是最大的数
 * 3) 针对所有元素重复以上步骤， 除了第一个元素
 * 4) 持续每次对越来越少的元素重复上面的步骤，直到没有任何一对数字需要比较。
 * 
 * 平均时间复杂度: O(n*n)
 */
function bubble_sort($array)
{
    $size = sizeof( $array );           //元素个数
    $i = 0;
    for(; $i < $size; $i++)
    {
        for($j = $size - 1; $j > $i; $j--)
        {
            if( $array[$i] > $array[$j] )
            {
                $tmp = $array[$i];
                $array[$i] = $array[$j];
                $array[$j] = $tmp;
            }
        }
    }
    return $array;
}

/**
 * 分治法排序
 *               array()
 *                /   \
 *               /     \
 *             left()  right()
 *             / \          / \
 *            /   \        /   \
 *           /     \      /     \
 *        left() right() left   right
 *
 */
function merge_sort($array)
{
    // 如果数组只有一个元素， 就返回这个数组
    $size = sizeof($array);
    if ( $size <= 1)
    {
        return $array;
    }

    $middle = (int) ($size/2);
    //分割成左右子数组
    $left = array_slice($array, 0, $middle);
    $right = array_slice($array, $middle);

    //递归左右子数组
    $left = merge_sort($left);
    $right = merge_sort($right);

    $i = $j = 0;
    $tmp = array();

    while(sizeof($left) != $i && sizeof($right) != $j)
    {
        if($left[$i] < $right[$j])
        {
            $tmp[] = $left[$i];
            $i++;
        } else {
            $tmp[] = $right[$j];
            $j++;
        }
    }

    // 如果其中一个子数组先被合并完，然后再将另外一个数组中剩余的合并起来
    if($i == sizeof($left))
    {
        $tmp = array_merge($tmp, array_slice($right, $j));
    }

    if($j == sizeof($right))
    {
        $tmp = array_merge($tmp, array_slice($left, $i));
    }
    return $tmp;
}

/**
 * 归并排序(Merge)是建立在归并操作上的一种有效的排序算法。 
 * 该算法是采用分治法(Divide and Conquer)的一个非常典型的应用。
 * 将已有序的子序列合并， 得到完全有序的序列；即先使每个子序列段间有序。
 * 若将两个有序表合并成一个有序表，称为2-路归并。
 * 
 * 工作原理
 *  1) 申请空间， 使其大小为两个已经排序序列值和， 该空间用来存放合并后的序列
 *  2) 设置两个指针， 最初位置分别为两个已经排序序列的起始位置
 *  3) 比较两个指针所指向的元素， 选择相对小的元素放入到合并空间， 并移动指针到下一个位置
 *  4) 重复前面三个步骤， 知道某一指针达到序列尾部。
 *  5) 将另一序列剩下的元素直接复制到合并序列列尾
 * 参数:
 *  $array1 : 已排序好的序列1
 *  $size_1 : 以排序序列1的元素数量
 *  $array2 : 已排序号的序列2
 *  $size_2 : 以排序序列2的元素数量
 *  $merged : 合并后的序列
 */
function binary_merge_sort(&$array1, $size_1, &$array2, $size_2, &$merged)
{
    $i = $j = 0; //序列的指针计数
    while ($i < $size_1 && $j < $size_2)
    {
        if($array1[$i] == $array2[$j])
        { // 如果两个序列中给定元素相等， 则输出该元素为交集
            $merged[] = $array1[$i];
            $merged[] = $array2[$j];
            echo $array1[$i] . PHP_EOL;
            $j++;
            $i++;
        } elseif($array1[$i] > $array2[$j]) { // 如果序列1中的第$i个元素比序列2的$j个元素大， 则将序列2中的元素放入合并序列
            $merged[] = $array2[$j];
            $j++;
        } else { // 否则将第一个序列中的元素放入合并序列
            $merged[] = $array1[$i];
            $i++;
        }
    }

    if($i < $size_1)
    { // 如果第一个序列还有剩余元素， 则直接将其放入合并序列
        for(; $i < $size_1; $i++)
        {
            $merged[] = $array1[$i];
        }
    }

    if($j < $size_2)
    { // 如果第二个序列还有剩余元素， 则直接将其放入合并序列
        for(; $j < $size_2; $j++)
        {
            $merged[] = $array2[$j];
        }
    }
}

/**
 * 二分查找(折半查找)
 *  优点 : 比较次数少，查找速度快，平均性能好
 *  缺点 : 要求待查表为有序表， 且插入删除困难
 * 适用范围:
 *  适用于不经常变动而查找频繁的有序列表。
 *  首先假设表中元素是按升序排列，将表中间位置记录的关键字与查找关键字比较， 如果两者相等，则查找成功。
 *  否则利用中间位置记录将表分成前后两个字表， 如果中间位置记录的关键词大于查找关键字， 则进一步查找前一个子表， 否则进一步查找后一个子表。
 *  重复以上过程，直到找到满足条件的记录， 使查找成功， 或直到子表不存在为止，此时查找不成功。
 */
function binary_search($findme, $sortedArray)
{
    $size = sizeof($sortedArray);
    $top = $size - 1;
    $low = 0;
    $middle = 0;

    while ($low <= $top)
    {
        $middle = floor(($top + $low) / 2);
        if($sortedArray[$middle] == $findme)
        {
            return $middle;
        }
        if($sortedArray[$middle] > $findme)
        {
            $top = $middle - 1;
        } else {
            $low = $middle + 1;
        }
    }
    return false;
}

/**
 * 快速排序1
 * 采用第一个元素作为中值，并使用两个额外的数组$leftArray, $rightArray
 * 将原数组中比中值小的都放在$leftArray中，比中值大的放在$rightArray中
 * 然后再分别对$leftArray, $rightArray采用上述步骤。
 * 
 * 最终合并$leftArray, $middle, $rightArray
 * 优点: 思想简单， 容易实现
 * 缺点: 损失大量空间， 同时使用array_merge这种性能不高的方式完成
 */
function quick_sort1($array)
{
    $size = count($array);
    if($size <= 1) return $array;
    $middle = $array[0];
    $leftArray = $rightArray = array();
    for($i = 1; $i < $size; $i++)
    {
        if($array[$i] > $middle)
        {
            $rightArray[] = $array[$i];
        } else {
            $leftArray[] = $array[$i];
        }
    }

    // 分治左右子数组
    $leftArray = quick_sort1($leftArray);
    $rightArray = quick_sort1($rightArray);
    // 合并返回
    return array_merge($leftArray, array($middle), $rightArray);
}

/**     0   1   2   3    4   5   6
 * $a = 9   8   10  15   6   3   21        mid=0 start=0 end=6 中值为$a[0] = 9
 * 1) 从左到右循环找比$a[0]小的，mid++, 互换两个值
 *      9   8   10  15   6   3   21        mid = 1 i = 1 交换$a[1] 和 $a[1] 等于没有交换
 *      9   8   10  15   6   3   21        mid = 1 i = 2 循环不做什么
 *      9   8   10  15   6   3   21        mid = 1 i = 3 循环不做什么
 *      9   8   6   15   10  3   21        mid = 2 i = 4 $a[2]和$[4]交换
 *      9   8   6   3    10  15  21        mid = 3 i = 5 $a[3]和$[5]交换
 * 2) 交换此时mid对应的值和start值, 即交换$a[3]和$a[0]
 *      3   8   6   9    10  15  21
 * 3) 然后划分两个子数组，分别做上述操作
        3   8   6   和   10  15  21
 * 最终排序结果:
 *      3   6   8   9    10  15  21
 */
function quick_sort2(&$array, $start, $end)
{
    if ($start >= $end) return;
/*    $mid = $start;
    for ($i = $start + 1; $i <= $end; $i++) {
        if ($array[$i] < $array[$mid]) {
            $mid++;
            $tmp = $array[$i];
            $array[$i] = $array[$mid];
            $array[$mid] = $tmp;
        }
    }

    $tmp = $array[$start];
    $array[$start] = $array[$mid];
    $array[$mid] = $tmp;*/
    $mid = getAdjustPosition($array, $start, $end);
    quick_sort2($array, $start, $mid - 1);
    quick_sort2($array, $mid + 1, $end);
}
/** 返回调整后基准数的位置
 * 使用第一个元素作为基准， 找到它排序好后应该在的位置
 * 从小到大的顺序排列
 *  1) 首先取出一个元素， 这里开始取出第一个元素， 那么这个位置就留下一个坑，这里叫做小数坑。
 *      并把这个元素保存为基准数， 同时保存$i为数组开始位置，$j为数组最右边的位置
 *  2) 先从右到左找一个比基准数小的元素来填上一步中的小数坑，那么在右边就留下了一个大数坑
 *  3) 然后在从左到右找一个比基准数大的元素来填充上一步中的大数坑， 那么在左边又出现了一个小数坑
 *  4) 重复2,3，直到$i == $j
 *     当$i == $j 的时候， 表示这个位置就是排序好用来存放基准数的坑位置， 那么就将基准数塞在这里，并返回这个位置值。
 *  5) 以这个位置作为分界点，将原数组分割为两部分， 然后分别对两部分执行递归迭代上述4步骤
 *  最终的数组就是完全排序好的结果
 */
function getAdjustPosition(&$array, $start, $end)
{
    $i = $start;
    $j = $end;
    $middle = $array[$start];
    while($i < $j)
    {
        // 从右向左找比$middle小的数来填充$array[$i], 开始$i对应的元素为坑， 需要找个小的来填充
        while($i < $j && $array[$j] > $middle)
            $j--;
        if($i < $j)
        {
            $array[$i] = $array[$j];
            $i++;
        }

        // 从左向右找比$middle大的数字填充$array[$j]; 填充完$i后， $j成为坑， 需要找个大的来填充
        while($i < $j && $array[$i] < $middle)
            $i++;
        if($i < $j)
        {
            $array[$j] = $array[$i];
            $j--;
        }
    }

    // 退出的时候 $i == $j， 这时将$middle就填充到这个位置，并返回$i
    $array[$i] = $middle;
    return $i;
}

/** 将上述两个方法合并简化版本
 */
function quick_sort(&$array, $start, $end)
{
    if($start < $end)
    {
        //首先选择一个基准数， 并找到其排序后应该在的位置，这里选择$start对应的元素
        $baseElement = $array[$start]; // 基准元素取出后， 这个位置就留下一个坑， 这个为小数坑
        $i = $start;
        $j = $end;
        while($i < $j)
        {
            // 从右向左找一个比基准数小的元素
            while($i < $j && $array[$j] > $baseElement)
                $j--;
            if($i < $j)
                $array[$i++] = $array[$j];    // 用找到的小数填充原来的坑， 那么$J对应的位置留下了个坑，叫做大数坑

            // 然后从左到右找一个比基准数大的元素
            while($i < $j && $array[$i] < $baseElement)
                $i++;
            if($i < $j)
                $array[$j--] = $array[$i];
        }
        $array[$i] = $baseElement;
        quick_sort($array, $start, $i - 1);
        quick_sort($array, $i + 1, $end);
    }
}